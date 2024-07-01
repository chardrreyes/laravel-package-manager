<?php

namespace App\Services;

class Items
{
    public string $name;
    public int $length;
    public int $width;
    public int $height;
    public float $weight;
    public int $quantity;

    public function __construct(string $name, int $length, int $width, int $height, float $weight, int $quantity)
    {
        $this->name = $name;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->weight = $weight;
        $this->quantity = $quantity;
    }

    public function calculateVolume(): int
    {
        return $this->length * $this->width * $this->height;
    }

    public function calculateTotalVolume(): int
    {
        return $this->calculateVolume() * $this->quantity;
    }
}