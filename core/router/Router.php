<?php

namespace Core\Router;

require_once __DIR__ . '/exceptions.php';

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

        $controller = new $Controller;

        $action = $parameters->getAction();

        if (!$controller->actionExists($action))
            throw new ActionNotFoundException("$Controller::$action");

        $controller->$action();
    }

    public static function redirect(string $path): void
    {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $path, true, 303);
        exit;
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
