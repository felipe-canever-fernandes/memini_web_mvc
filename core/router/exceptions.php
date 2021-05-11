<?php

namespace Core\Router;

use Exception;
use Throwable;

class ActionNotFoundException extends Exception
{
    public function __construct(string $action, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Action '$action' not found.", $code, $previous);
    }
}

class ControllerNotFoundException extends Exception
{
    public function __construct(string $controller, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Controller '$controller' not found.", $code, $previous);
    }
}

class RouteNotFoundException extends Exception
{
    public function __construct(string $path, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Route '$path' not found.", $code, $previous);
    }
}
