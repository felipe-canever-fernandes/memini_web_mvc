<?php

namespace App\Models\User;

use Exception;
use Throwable;

class PasswordNotSetException extends Exception
{
    private array $errors;

    public function __construct(int $code = 0, Throwable $previous = null)
    {
        parent::__construct('The user password has not been set.', $code, $previous);
    }
}
