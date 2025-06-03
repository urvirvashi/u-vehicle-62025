<?php 

namespace App\DTO;

class VehicleTechnicalDetailDTO
{
    public float $topSpeed;
    public float $length;
    public float $width;
    public float $height;
    public string $engineType;
    public string $fuelType;

    public function __construct(
        float $topSpeed, float $length, float $width, float $height,
        string $engineType, string $fuelType
    ) {
        $this->topSpeed = $topSpeed;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->engineType = $engineType;
        $this->fuelType = $fuelType;
    }
}
