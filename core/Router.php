<?php

namespace Core;

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function add(string $route, array $parameters): void
    {
        $this->routes[$route] = $parameters;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
