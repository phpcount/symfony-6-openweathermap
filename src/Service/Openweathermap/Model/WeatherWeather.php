<?php

namespace App\Service\Openweathermap\Model;

class WeatherWeather
{
    public function __construct(
        private int $id,
        private string $main,
        private string $description,
        private string $icon,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMain(): string
    {
        return $this->main;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }
}
