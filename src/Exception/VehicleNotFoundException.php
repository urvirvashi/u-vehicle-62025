<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VehicleNotFoundException extends NotFoundHttpException
{
    public function __construct(string $message = 'Vehicle details not found', \Throwable $previous = null, int $code = 0)
    {
        parent::__construct($message, $previous, $code);
    }
}
