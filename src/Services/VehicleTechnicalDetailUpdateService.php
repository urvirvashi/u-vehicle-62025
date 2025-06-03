<?php

namespace App\Services;

use App\Entity\VehicleTechnicalDetail;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityManagerInterface;

class VehicleTechnicalDetailUpdateService
{
    private const TECHNICAL_FIELDS = [
        'topSpeed', 'length', 'width', 'height', 'engineType',
        'fuelType', 'engineCapacity', 'driveSystem', 'weight', 'wheelBase'
    ];

    public function __construct(
        private ValidatorInterface $validator
    ) {}

    public function update(VehicleTechnicalDetail $detail, array $data): array
    {
       // Only keep keys that are technical parameters
        $fieldsToUpdate = array_intersect(array_keys($data), self::TECHNICAL_FIELDS);

        // Enforce the limit: no more than 10 fields
        if (count($fieldsToUpdate) > 10) {
            return ['error' => 'You can only update up to 10 technical parameters at once.'];
        }

        // Optionally, reject if any field is not allowed
        $extraFields = array_diff(array_keys($data), self::TECHNICAL_FIELDS);
        if ($extraFields) {
            return ['error' => 'Invalid fields: ' . implode(', ', $extraFields)];
        }

        // Set the values
        foreach ($fieldsToUpdate as $field) {
            $setter = 'set' . ucfirst($field);
            if (method_exists($detail, $setter)) {
                $detail->$setter($data[$field]);
            }
        }

        // Validate
        $errors = $this->validator->validate($detail);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
            }
            return $errorMessages;
        }

        return [];
    }
}
