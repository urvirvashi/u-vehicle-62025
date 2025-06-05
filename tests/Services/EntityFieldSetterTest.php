<?php

namespace App\Tests\Services;

use App\Services\EntityFieldSetter;
use PHPUnit\Framework\TestCase;

class DummyEntity
{
    private ?string $name = null;
    private ?int $age = null;

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }
    public function getAge(): ?int
    {
        return $this->age;
    }
}

class EntityFieldSetterTest extends TestCase
{
    public function testFieldsAreSetCorrectly(): void
    {
        $setter = new EntityFieldSetter();
        $entity = new DummyEntity();

        $data = ['name' => 'John', 'age' => 30];
        $fields = ['name', 'age'];

        $setter->setFields($entity, $data, $fields);

        $this->assertEquals('John', $entity->getName());
        $this->assertEquals(30, $entity->getAge());
    }

    public function testIgnoresInvalidSetters(): void
    {
        $setter = new EntityFieldSetter();
        $entity = new DummyEntity();

        $data = ['name' => 'John', 'height' => 180];
        $fields = ['name', 'height']; // 'height' has no setter

        $setter->setFields($entity, $data, $fields);

        $this->assertEquals('John', $entity->getName());
        $this->assertNull(method_exists($entity, 'getHeight') ? $entity->getHeight() : null);
    }
}
