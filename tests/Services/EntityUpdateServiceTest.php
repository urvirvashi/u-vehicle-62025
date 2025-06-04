<?php

namespace App\Tests\Services;

use App\Services\EntityFieldSetter;
use App\Services\EntityFieldValidator;
use App\Services\EntityUpdateService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use stdClass;

class EntityUpdateServiceTest extends TestCase
{
    private $validator;
    private $fieldValidator;
    private $fieldSetter;
    private EntityUpdateService $service;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->fieldValidator = $this->createMock(EntityFieldValidator::class);
        $this->fieldSetter = $this->createMock(EntityFieldSetter::class);

        $this->service = new EntityUpdateService(
            $this->validator,
            $this->fieldValidator,
            $this->fieldSetter
        );
    }

    public function testSuccessfulUpdateReturnsNoErrors(): void
    {
        $entity = new stdClass();
        $data = ['length' => 4.5];
        $allowedFields = ['length'];

        $this->fieldValidator->method('validate')
            ->willReturn(['validFields' => ['length']]);

        $this->fieldSetter->expects($this->once())
            ->method('setFields')
            ->with($entity, $data, ['length']);

        $this->validator->method('validate')
            ->willReturn(new ConstraintViolationList());

        $result = $this->service->updateEntity($entity, $data, $allowedFields);

        $this->assertEmpty($result);
    }

    public function testUpdateReturnsValidationErrors(): void
    {
        $entity = new stdClass();
        $data = ['length' => 4.5];
        $allowedFields = ['length'];

        $this->fieldValidator->method('validate')
            ->willReturn(['validFields' => ['length']]);

        $this->fieldSetter->expects($this->once())
            ->method('setFields');

        $violation = $this->createMock(ConstraintViolation::class);
        $violation->method('getPropertyPath')->willReturn('length');
        $violation->method('getMessage')->willReturn('Must be positive.');

        $violations = new ConstraintViolationList([$violation]);

        $this->validator->method('validate')->willReturn($violations);

        $result = $this->service->updateEntity($entity, $data, $allowedFields);

        $this->assertArrayHasKey('length', $result);
        $this->assertContains('Must be positive.', $result['length']);
    }

    public function testUpdateReturnsErrorForInvalidFields(): void
    {
        $entity = new stdClass();
        $data = ['invalidField' => 'value'];
        $allowedFields = ['length'];

        $this->fieldValidator->method('validate')
            ->willReturn(['error' => 'Invalid fields: invalidField']);

        $this->fieldSetter->expects($this->never())->method('setFields');
        $this->validator->expects($this->never())->method('validate');

        $result = $this->service->updateEntity($entity, $data, $allowedFields);

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Invalid fields: invalidField', $result['error']);
    }
}
