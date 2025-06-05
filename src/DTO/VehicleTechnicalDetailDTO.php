<?php

namespace App\DTO;

class VehicleTechnicalDetailDTO
{
    public ?int $topSpeed = null;
    public ?int $length = null;
    public ?int $width = null;
    public ?int $height = null;
    public ?string $engineType = null;
    public ?string $fuelType = null;
    public ?int $engineCapacity = null;
    public ?string $driveSystem = null;
    public ?int $weight = null;
    public ?int $wheelBase = null;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
