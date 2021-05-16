<?php

namespace App\Models;

use Exception;
use Throwable;

class ValidationErrorException extends Exception
{
    private array $errors;

    public function __construct(
        string $model, array $errors, int $code = 0, Throwable $previous = null
    )
    {
        parent::__construct("Failed validation in object of model $model.", $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
