<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Length;

class SearchRequest
{
    #[Length(min: 2)]
    private string $text;

    private string $units;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getUnits(): string
    {
        return $this->units;
    }

    public function setUnits(string $units): self
    {
        $this->units = $units;

        return $this;
    }
}
