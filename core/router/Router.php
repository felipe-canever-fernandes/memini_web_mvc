<?php

namespace Core\Router;

use OutOfBoundsException;

require_once 'Parameters.php';

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function add(string $path, Parameters $parameters): void
    {
        $this->routes[$path] = $parameters;
    }

    public function match(string $path): Parameters
    {
        if (!array_key_exists($path, $this->routes))
            throw new OutOfBoundsException('Route not found.');

        return $this->routes[$path];
    }
}
