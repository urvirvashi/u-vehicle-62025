<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\DTO\VehicleTechnicalDetailDTO;
use App\Services\VehicleTechnicalDetailUpdateService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Vehicle;

#[Route('/api')]
final class VehicleTechDetailController extends AbstractController
{
   #[Route('/vehicle-tech-detail/{id}', name: 'api_vehicle_tech_detail_update', methods: ['PATCH'])]
    public function updateTechnical(
        Request $request,
        EntityManagerInterface $em,
        VehicleTechnicalDetailUpdateService $updateService,
        int $id
    ): JsonResponse {
        $vehicle = $em->getRepository(Vehicle::class)->find($id);
    if (!$vehicle || !$vehicle->getVehicleTech()) {
        return $this->json(['error' => 'Vehicle or details not found'], 404);
    }
    $details = $vehicle->getVehicleTech();
    $data = json_decode($request->getContent(), true);

    $errors = $updateService->update($details, $data);
    if ($errors) {
        return $this->json($errors, 400);
    }

    $em->flush();
    return $this->json(['message' => 'Technical details updated']);
    }
}
