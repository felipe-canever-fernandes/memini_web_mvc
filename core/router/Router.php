<?php

namespace Core\Router;

require_once "Parameters.php";

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function add(string $path, Parameters $parameters): void
    {
        $this->routes[$path] = $parameters;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
