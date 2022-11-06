<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Request\SearchRequest;
use App\Service\Openweathermap\OpenweathermapApiService;
use App\Utils\WeatherUnitsMeasurement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class HomeController extends AbstractController
{
    public function __construct(
        private CacheInterface $redisСache,
        private SerializerInterface $serializer,
        private SluggerInterface $slugger
        ) {
    }

    #[Route('/', methods: ['GET'], name: 'app_home')]
    public function index(
        Request $request
    ): Response {
        $form = $this->createForm(SearchFormType::class, new SearchRequest());
        $data = [];

        $dataWeather = $request->get('data_weather');
        if (null !== $dataWeather) {
            $data = json_decode(base64_decode($dataWeather), true);
            if (!$data) {
                return $this->redirectToRoute('app_home', []);
            }
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            ...$data,
        ]);
    }

    #[Route('/', methods: ['POST'], name: 'app_search-form')]
    public function searchForm(
        OpenweathermapApiService $openweathermapApiService,
        Request $request
    ): Response {
        $searchRequest = new SearchRequest();
        $form = $this->createForm(SearchFormType::class, $searchRequest);

        $q = null;
        $weatherReponse = null;
        $unitMeasurement = 'standard';

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $q = $searchRequest->getText();
            $unitMeasurement = $searchRequest->getUnits();
            $weatherUnits = new WeatherUnitsMeasurement($unitMeasurement);
        }

        if ($q) {
            $weatherReponse = $this->redisСache->get(
                'app.search_weather-'.$this->slugger->slug($q.$unitMeasurement),
                function ($item) use ($q, $openweathermapApiService, $unitMeasurement) {
                    $item->expiresAfter(10);

                    $zip = ctype_digit($q) ? (int) $q : null;

                    return $openweathermapApiService->weather($q, $zip, units: $unitMeasurement);
                }
            );
        }

        return $this->redirectToRoute('app_home', [
            'data_weather' => base64_encode($this->serializer->serialize([
                'q' => $q,
                'measurements' => $weatherUnits->getMeasurements(),
                'weather' => $weatherReponse,
            ], JsonEncoder::FORMAT)),
        ]);
    }
}
