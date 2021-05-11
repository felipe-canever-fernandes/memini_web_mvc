<?php

namespace Core\Router;

use Exception;
use Throwable;

class ActionNotFoundException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class ControllerNotFoundException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class RouteNotFoundException extends Exception
{
    public function __construct(string $path, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Route '$path' not found.", $code, $previous);
    }
}
