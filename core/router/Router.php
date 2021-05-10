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

    public function addPathPattern(string $pathPattern, Callable $matcher): void
    {
        $pathPattern = preg_replace('/\//', '\\/', $pathPattern);
        $pathPattern = preg_replace('/{([a-z]+)}/', '(?P<\1>[a-z-]+)', $pathPattern);

        if (empty($pathPattern))
            $pathPattern = '(?![\s\S])';

        $pathPattern = "/^$pathPattern$/i";

        $this->routes[$pathPattern] = $matcher;
    }

    public function addPath(string $path, Parameters $parameters): void
    {
        $this->addPathPattern($path, fn($matches) => $parameters);
    }

    public function match(string $path): Parameters
    {
        foreach ($this->routes as $pattern => $matcher)
            if (preg_match($pattern, $path, $matches))
                return $matcher($matches);

        throw new OutOfBoundsException('Route not found.');
    }
}
