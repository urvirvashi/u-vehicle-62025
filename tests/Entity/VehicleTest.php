<?php

namespace App\Tests\Entity;

use App\Entity\Vehicle;
use App\Entity\VehicleTechnicalDetail;
use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    public function testVehicleProperties(): void
    {
        $vehicle = new Vehicle();
        $vehicle->setName('Model X');
        $vehicle->setType('SUV');

        $this->assertEquals('Model X', $vehicle->getName());
        $this->assertEquals('SUV', $vehicle->getType());

        $techDetail = new VehicleTechnicalDetail();
        $vehicle->setVehicleTech($techDetail);

        $this->assertSame($techDetail, $vehicle->getVehicleTech());
        $this->assertSame($vehicle, $techDetail->getVehicle());
    }
}
