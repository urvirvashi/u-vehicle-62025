<?php

namespace App\Services;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityUpdateService
{
    public function __construct(
        private ValidatorInterface $validator,
        private EntityFieldValidator $fieldValidator,
        private EntityFieldSetter $fieldSetter
    ) {}

    public function updateEntity(
        object $entity,
        array $data,
        array $allowedFields,
        int $limit = 10
    ): array {
        $validation = $this->fieldValidator->validate($data, $allowedFields, $limit);

        if (isset($validation['error'])) {
            return ['error' => $validation['error']];
        }

        $this->fieldSetter->setFields($entity, $data, $validation['validFields']);

        $errors = $this->validator->validate($entity);
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
