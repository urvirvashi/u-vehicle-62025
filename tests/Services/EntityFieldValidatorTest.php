<?php

namespace App\Tests\Services;

use App\Services\EntityFieldValidator;
use PHPUnit\Framework\TestCase;

class EntityFieldValidatorTest extends TestCase
{
    private EntityFieldValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new EntityFieldValidator();
    }

    public function testReturnsValidFieldsWhenAllAreAllowed(): void
    {
        $input = [
            'length' => 4.5,
            'width' => 2.0
        ];
        $allowedFields = ['length', 'width', 'height'];

        $result = $this->validator->validate($input, $allowedFields);

        $this->assertArrayHasKey('validFields', $result);
        $this->assertEquals(['length', 'width'], $result['validFields']);
    }

    public function testReturnsErrorWhenExtraFieldsProvided(): void
    {
        $input = [
            'length' => 4.5,
            'color' => 'red'
        ];
        $allowedFields = ['length', 'width', 'height'];

        $result = $this->validator->validate($input, $allowedFields);

        $this->assertArrayHasKey('error', $result);
        $this->assertStringContainsString('Invalid fields: color', $result['error']);
    }

    public function testReturnsEmptyWhenInputIsEmpty(): void
    {
        $input = [];
        $allowedFields = ['length', 'width'];

        $result = $this->validator->validate($input, $allowedFields);

        $this->assertArrayHasKey('validFields', $result);
        $this->assertEmpty($result['validFields']);
    }

    public function testReturnsOnlyMatchingFields(): void
    {
        $input = [
            'height' => 1.6,
            'weight' => 1400
        ];
        $allowedFields = ['height', 'width', 'length'];

        $result = $this->validator->validate($input, $allowedFields);

        $this->assertArrayHasKey('error', $result);
        $this->assertStringContainsString('Invalid fields: weight', $result['error']);
    }
}
