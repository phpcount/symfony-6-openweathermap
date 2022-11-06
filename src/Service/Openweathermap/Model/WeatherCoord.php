<?php

namespace App\Service\Openweathermap\Model;

class WeatherCoord
{
    public function __construct(
        private float $lon,
        private float $lat,
    ) {
    }

    public function getLon(): float
    {
        return $this->lon;
    }

    public function getLat(): float
    {
        return $this->lat;
    }
}
