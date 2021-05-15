<?php

namespace Core\Router;

require_once 'Exceptions.php';
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

    /**
     * @throws RouteNotFoundException
     * @throws ControllerNotFoundException
     * @throws ActionNotFoundException
     */
    public function dispatch(string $path): void
    {
        $parameters = $this->match($path);

        $Controller = "\\App\\Controllers\\{$parameters->getController()}";

        if (!class_exists($Controller))
            throw new ControllerNotFoundException($Controller);

        $action = $parameters->getAction();

        if (!is_callable($Controller, $action))
            throw new ActionNotFoundException($action);

        $Controller::$action();
    }

    /**
     * @throws RouteNotFoundException
     */
    private function match(string $path): Parameters
    {
        foreach ($this->routes as $pattern => $matcher)
            if (preg_match($pattern, $path, $matches))
                return $matcher($matches);

        throw new RouteNotFoundException($path);
    }
}
