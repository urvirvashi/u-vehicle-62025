<?php

namespace App\Tests\Services;

use App\Entity\VehicleTechnicalDetail;
use App\Services\VehicleTechnicalDetailUpdateService;
use App\Services\EntityUpdateService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;
use App\DTO\VehicleTechnicalDetailDTO;

class VehicleTechnicalDetailUpdateServiceTest extends TestCase
{
    private EntityUpdateService $entityUpdateService;
    private ValidatorInterface $validator;
    private VehicleTechnicalDetailUpdateService $service;

    protected function setUp(): void
    {
        $this->entityUpdateService = $this->createMock(EntityUpdateService::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->service = new VehicleTechnicalDetailUpdateService(
            $this->entityUpdateService,
            $this->validator
        );
    }

    public function testSuccessfulUpdate(): void
    {
        $dto = new VehicleTechnicalDetailDTO(120.0, 4.5, 2.0, 1.5, 'V6', 'Petrol');
        $entity = $this->createMock(VehicleTechnicalDetail::class);

        $this->entityUpdateService->expects($this->once())
            ->method('updateEntity')
            ->with($entity, get_object_vars($dto), $this->anything())
            ->willReturn([]);

        $errors = $this->service->update($entity, $dto, 3);

        $this->assertEmpty($errors);
    }

    public function testExceedsFieldLimit(): void
    {
        $dto = new VehicleTechnicalDetailDTO(120.0, 4.5, 2.0, 1.5, 'V6', 'Petrol');
        $entity = $this->createMock(VehicleTechnicalDetail::class);

        // Exceeds the limit of 3 fields
        $errors = $this->service->update($entity, $dto, 6);

        $this->assertArrayHasKey('error', $errors);
        $this->assertEquals(
            'You can only update up to 3 fields at once.',
            $errors['error']
        );
    }

    public function testEntityUpdateServiceReturnsErrors(): void
    {
        $dto = new VehicleTechnicalDetailDTO(120.0, 4.5, 2.0, 1.5, 'V6', 'Petrol');
        $entity = $this->createMock(VehicleTechnicalDetail::class);

        $expectedErrors = ['length' => ['This value should be greater than zero.']];

        $this->entityUpdateService->method('updateEntity')
            ->willReturn($expectedErrors);

        $errors = $this->service->update($entity, $dto, 2);

        $this->assertEquals($expectedErrors, $errors);
    }
}
