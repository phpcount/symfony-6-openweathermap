<?php

namespace App\Service\Openweathermap;

use App\Service\Openweathermap\Model\WeatherReponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenweathermapApiService
{
    public function __construct(
        private HttpClientInterface $openweathermapClient,
        private SerializerInterface $serializer,
        private string $openweathermapToken,
        private LoggerInterface $logger,
    ) {
    }

    public function weather(string $q, int $zip = null, int $limit = 1, string $lang = 'ru', string $units = 'standard'): ?WeatherReponse
    {
        $queryData = [];
        if ($q) {
            $queryData += compact('q');
        }
        if ($zip) {
            $queryData += compact('zip');
        }

        try {
            $response = $this->openweathermapClient->request('GET', '/data/2.5/weather', [
                'query' => [
                    'limit' => $limit,
                    'appid' => $this->openweathermapToken,
                    'units' => $units,
                    'lang' => $lang,
                ] + $queryData,
            ]);

            $this->logger->debug($response->getContent());
            $reponse = $this->serializer->deserialize(
                $response->getContent(),
                WeatherReponse::class,
                JsonEncoder::FORMAT
            );

            return $reponse;
        } catch (\Throwable $ex) {
            $this->logger->error($ex->getMessage());

            if (Response::HTTP_NOT_FOUND === $ex->getCode()) {
                return null;
            }
        }
    }
}
