<?php

namespace App\Service\Openweathermap\Model;

class WeatherWind
{
    public function __construct(
        private float $speed,
        private float $deg,
    ) {
    }

    public function getSpeed(): float
    {
        return $this->speed;
    }

    public function getDeg(): float
    {
        return $this->deg;
    }
}
