<?php

// src/Twig/AppExtension.php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('temp', [$this, 'formatTemperature']),
        ];
    }

    public function formatTemperature(float $number): int
    {
        $tempRounded = round($number);

        return $tempRounded;
    }
}
