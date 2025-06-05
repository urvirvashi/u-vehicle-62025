<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Vehicle;
use App\Entity\VehicleTechnicalDetail;
use App\Exception\VehicleNotFoundException;

#[Route('/api')]
final class VehicleController extends AbstractController
{
    #[Route('/vehicle/{id}', name: 'api_vehicle_details', methods: ['GET'])]
    public function vehicleDetails(EntityManagerInterface $em, int $id): JsonResponse
    {
        try {
            $vehicle = $em->getRepository(Vehicle::class)->find($id);
            if (!$vehicle) {
                throw new VehicleNotFoundException();
            }

            return $this->json($vehicle, 200, [], ['groups' => 'vehicle:read']);
        } catch (VehicleNotFoundException $e) {
            // You can customize the error response here
            return $this->json([
                'error' => $e->getMessage(),
                'code'  => 404
            ], 404);
        } catch (\Exception $e) {
            // Optional: handle other exceptions
            return $this->json([
                'error' => 'Internal Server Error',
                'code'  => 500
            ], 500);
        }
    }

    #[Route('/vehicle-tech-detail/{id}', name: 'api_vehicle_tech_details', methods: ['GET'])]
    public function vehicleTechDetails(EntityManagerInterface $em, int $id): JsonResponse
    {
        try {
            $vehicle = $em->getRepository(Vehicle::class)->find($id);
            if (!$vehicle || !$vehicle->getVehicleTech()) {
                throw new VehicleNotFoundException();
            }

            return $this->json($vehicle, 200, [], ['groups' => 'vehicleTechDetail:read']);
        } catch (VehicleNotFoundException $e) {
            // You can customize the error response here
            return $this->json([
                'error' => $e->getMessage(),
                'code'  => 404
            ], 404);
        } catch (\Exception $e) {
            // Optional: handle other exceptions
            return $this->json([
                'error' => 'Internal Server Error',
                'code'  => 500
            ], 500);
        }
    }
}
