<?php

namespace App\Service\Openweathermap\Model;

class WeatherMain
{
    public function __construct(
        private float $temp,
        private int $pressure,
        private int $humidity,
    ) {
    }

    public function getTemp(): float
    {
        return $this->temp;
    }

    public function getPressure(): int
    {
        return $this->pressure;
    }

    public function getHumidity(): int
    {
        return $this->humidity;
    }
}
