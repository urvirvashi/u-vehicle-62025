<?php

namespace App\Tests\Services;

use App\Entity\VehicleTechnicalDetail;
use App\Services\VehicleTechnicalDetailUpdateService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;

class VehicleTechnicalDetailUpdateServiceTest extends TestCase
{
    public function testUpdateWithValidData(): void
    {
        $detail = new VehicleTechnicalDetail();

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('validate')
            ->with($detail)
            ->willReturn(new ConstraintViolationList());

        $service = new VehicleTechnicalDetailUpdateService($validator);
        $data = ['topSpeed' => 240];

        $errors = $service->update($detail, $data);

        $this->assertEmpty($errors);
        $this->assertEquals(240, $detail->getTopSpeed());
    }

    public function testUpdateWithInvalidData(): void
    {
        $detail = new VehicleTechnicalDetail();

        // Simulate a validation violation
        $violation = $this->createMock(ConstraintViolation::class);
        $violation->method('getPropertyPath')->willReturn('topSpeed');
        $violation->method('getMessage')->willReturn('This value should not be blank.');

        $violations = new ConstraintViolationList([$violation]);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('validate')
            ->with($detail)
            ->willReturn($violations);

        $service = new VehicleTechnicalDetailUpdateService($validator);
        $data = ['topSpeed' => null]; // triggers validation error

        $errors = $service->update($detail, $data);

        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey('topSpeed', $errors);
        $this->assertEquals(['This value should not be blank.'], $errors['topSpeed']);
    }
}
