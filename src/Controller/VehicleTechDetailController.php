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
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Exception\VehicleNotFoundException;

#[Route('/api')]
final class VehicleTechDetailController extends AbstractController
{
    #[Route('/vehicle-tech-detail/{id}', name: 'api_vehicle_tech_detail_update', methods: ['PATCH'])]
    public function updateVehicleTechnicalData(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        VehicleTechnicalDetailUpdateService $updateService,
        SerializerInterface $serializer
    ): JsonResponse {
        try {
            $vehicle = $em->getRepository(Vehicle::class)->find($id);

            if (!$vehicle || !$vehicle->getVehicleTech()) {
                throw new VehicleNotFoundException('Vehicle or technical details not found');
            }

            $data = $request->getContent();
            if (empty($data)) {
                throw new BadRequestHttpException('Empty request body');
            }

            try {
                /** @var VehicleTechnicalDetailDTO $dto */
                $dto = $serializer->deserialize($data, VehicleTechnicalDetailDTO::class, 'json');
            } catch (\Exception $e) {
                throw new BadRequestHttpException('Invalid data: ' . $e->getMessage());
            }

            $errors = $updateService->update($vehicle->getVehicleTech(), $dto, count(json_decode($data, true)));
            if (!empty($errors)) {
                return $this->json($errors, 400);
            }

            $em->flush();
            return $this->json(['message' => 'Technical details updated']);
        } catch (VehicleNotFoundException | BadRequestHttpException $e) {
            return $this->json(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            return $this->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
