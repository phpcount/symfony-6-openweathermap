<?php

namespace App\Utils;

class WeatherUnitsMeasurement
{
    public const STANDARD = 'standard';
    public const IMPERIAL = 'imperial';
    public const METRIC = 'metric';

    public const UNITS = [
        self::STANDARD => 'стандартные',
        self::IMPERIAL => 'имперские',
        self::METRIC => 'метрические',
    ];

    private array $units;

    private string $unitMeasurement;

    public function __construct(string $unitMeasurement)
    {
        $this->unitMeasurement = $unitMeasurement;
        $this->units = [
            'temp' => $this->makeTempMeasurement(),
            'pressure' => 'мм рт. ст',
            'wind_speed' => $this->makeWindSpeedMeasurement(),
            'humidity' => '%',
        ];
    }

    public function getUnitMeasurement(): string
    {
        return $this->unitMeasurement;
    }

    public function getMeasurements(): array
    {
        return $this->units;
    }

    private function makeTempMeasurement(): string
    {
        switch ($this->unitMeasurement) {
            case self::IMPERIAL:
                return '°F';
            case self::METRIC:
                return '°C';
            default:
                return 'K';
        }
    }

    private function makeWindSpeedMeasurement(): string
    {
        switch ($this->unitMeasurement) {
            case self::IMPERIAL:
                return 'мили/час';
            case self::METRIC:
                return 'м/c';
            default:
                return 'м/c';
        }
    }
}
