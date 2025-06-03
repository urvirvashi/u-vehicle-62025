<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Maker;
use App\Entity\Vehicle;
use App\Entity\VehicleTechnicalDetail;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $maker = new Maker();
        $maker->setName('Toyota');
        $manager->persist($maker);

        $vehicle = new Vehicle();
        $vehicle->setName('UCar');
        $vehicle->setType('suv');
        $vehicle->setMaker($maker);
        $manager->persist($vehicle);

        $details = new VehicleTechnicalDetail();
        $details->setVehicle($vehicle)
            ->setTopSpeed(180)
            ->setLength(4.6)
            ->setWidth(1.8)
            ->setHeight(1.7)
            ->setEngineType('petrol')
            ->setFuelType('petrol');
        $manager->persist($details);

        $manager->flush();
    }
}
