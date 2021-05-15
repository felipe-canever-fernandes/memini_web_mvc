<?php

namespace Core\Router;

use Throwable;
use Core\NotFoundException;

class ActionNotFoundException extends NotFoundException
{
    public function __construct(string $action, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("action", $action, $code, $previous);
    }
}

class ControllerNotFoundException extends NotFoundException
{
    public function __construct(string $controller, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("controller", $controller, $code, $previous);
    }
}

class RouteNotFoundException extends NotFoundException
{
    public function __construct(string $path, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("route", $path, $code, $previous);
    }
}
