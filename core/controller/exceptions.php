<?php

namespace Core\Controller;

use Exception;
use Throwable;

class MethodNotFoundException extends Exception
{
    public function __construct(string $method, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Method '$method' not found.", $code, $previous);
    }
}
