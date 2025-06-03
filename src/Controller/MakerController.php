<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MakerRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api')]
final class MakerController extends AbstractController
{
    #[Route('/makers/by-type/{type}', name: 'api_makers_by_type', methods: ['GET'])]
    public function makersByType(MakerRepository $makerRepo, string $type): JsonResponse
    {
        $makers = $makerRepo->findMakersByType($type);

        return $this->json($makers, 200, [], ['groups' => 'maker:read']);
    }
}
