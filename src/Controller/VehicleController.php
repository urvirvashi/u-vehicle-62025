<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Maker;
use App\Entity\Vehicle;
use App\Entity\VehicleTechnicalDetail;
use App\Repository\MakerRepository;


#[Route('/api')]
final class VehicleController extends AbstractController
{
    #[Route('/test', name: 'api_test')]
    public function test(): JsonResponse
    {
        return $this->json(['status' => 'ok']);
    }

    #[Route('/makers/by-type/{type}', name: 'api_makers_by_type', methods: ['GET'])]
    public function makersByType(MakerRepository $makerRepo, string $type): JsonResponse
    {
        $makers = $makerRepo->findMakersByType($type);

        return $this->json($makers, 200, [], ['groups' => 'maker:read']);
    }

}
