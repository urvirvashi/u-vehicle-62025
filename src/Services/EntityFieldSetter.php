<?php

namespace App\Services;

class EntityFieldSetter
{
    /**
     * @param object $entity
     * @param array<string, mixed> $data
     * @param string[] $fields
     */
    public function setFields(object $entity, array $data, array $fields): void
    {
        foreach ($fields as $field) {
            $setter = 'set' . ucfirst($field);
            if (method_exists($entity, $setter)) {
                $entity->$setter($data[$field]);
            }
        }
    }
}
