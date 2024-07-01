<?php

namespace App\Services;

class BoxContainer
{
    public string $name;
    public int $length;
    public int $width;
    public int $height;
    public float $weightLimit;

    public function __construct(string $name, int $length, int $width, int $height, float $weightLimit)
    {
        $this->name = $name;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->weightLimit = $weightLimit;
    }

    public function calculateVolume(): int
    {
        return $this->length * $this->width * $this->height;
    }
}