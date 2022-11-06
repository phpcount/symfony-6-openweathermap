<?php

namespace App\Service\Openweathermap\Model;

class WeatherReponse
{
    public function __construct(
        private WeatherCoord $coord,
        private WeatherMain $main,
        private WeatherWind $wind,
        private array $weather,
        private string $name,
        private int $cod
    ) {
    }

    public function getCoord(): WeatherCoord
    {
        return $this->coord;
    }

    public function getMain(): WeatherMain
    {
        return $this->main;
    }

    public function getWind(): WeatherWind
    {
        return $this->wind;
    }

    /**
     * @return WeatherWeather[]
     */
    public function getWeather(): array
    {
        return $this->weather;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCod(): int
    {
        return $this->cod;
    }
}
