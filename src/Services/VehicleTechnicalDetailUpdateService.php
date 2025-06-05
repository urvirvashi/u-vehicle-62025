<?php

namespace App\Services;

use App\Entity\VehicleTechnicalDetail;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityManagerInterface;
use App\DTO\VehicleTechnicalDetailDTO;

class VehicleTechnicalDetailUpdateService
{
    private const TECHNICAL_FIELDS = [
        'topSpeed', 'length', 'width', 'height', 'engineType',
        'fuelType', 'engineCapacity', 'driveSystem', 'weight', 'wheelBase'
    ];

    private const REQUESTED_PARAMETER_LIMIT = 10;

    public function __construct(
        private EntityUpdateService $entityUpdateService
    ) {
    }

    /**
     * @return array{error: string}|array<string, string>
     */
    public function update(
        VehicleTechnicalDetail $detail,
        VehicleTechnicalDetailDTO $data,
        int $requestCount
    ): array {
        $data = get_object_vars($data);
        $errors = $this->entityUpdateService->updateEntity(
            $detail,
            $data,
            self::TECHNICAL_FIELDS
        );

        if ($requestCount > self::REQUESTED_PARAMETER_LIMIT) {
            return ['error' => 'You can only update up to ' . self::REQUESTED_PARAMETER_LIMIT . ' fields at once.'];
        }
        if (!empty($errors)) {
            return $errors;
        }
         return [];
    }
}
