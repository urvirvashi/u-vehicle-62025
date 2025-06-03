<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Vehicle;
use App\Entity\VehicleTechnicalDetail;

#[Route('/api')]
final class VehicleController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/vehicle/{id}', name: 'api_vehicle_details', methods: ['GET'])]
    public function vehicleDetails(EntityManagerInterface $em, int $id): JsonResponse
    {
        $vehicle = $em->getRepository(Vehicle::class)->find($id);
        if (!$vehicle) {
            return $this->json(['error' => 'Vehicle not found'], 404);
        }

        return $this->json($vehicle, 200, [], ['groups' => 'vehicle:read']);
    }

    #[Route('/vehicle-tech-detail/{id}', name: 'api_vehicle_tech_details', methods: ['GET'])]
    public function vehicleTechDetails(EntityManagerInterface $em, int $id): JsonResponse
    {
        $vehicle = $em->getRepository(Vehicle::class)->find($id);
        if (!$vehicle) {
            return $this->json(['error' => 'Vehicle not found'], 404);
        }

        return $this->json($vehicle, 200, [], ['groups' => 'vehicleTechDetail:read']);
    }

}
