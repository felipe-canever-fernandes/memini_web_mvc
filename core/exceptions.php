<?php

namespace Core;

use Exception;
use Throwable;

class NotFoundException extends Exception
{
    public function __construct(string $name, string $code_name, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(ucfirst($name) . " '$code_name' not found.", $code, $previous);
    }
}
