<?php
namespace App\Services;

class EntityFieldValidator
{
    public function validate(
        array $input, 
        array $allowedFields
    ): array
    {
        $fieldsToUpdate = array_intersect(array_keys($input), $allowedFields);
        $extraFields = array_diff(array_keys($input), $allowedFields);    

        if (!empty($extraFields)) {
            return ['error' => 'Invalid fields: ' . implode(', ', $extraFields)];
        }

        return ['validFields' => $fieldsToUpdate];
    }
}