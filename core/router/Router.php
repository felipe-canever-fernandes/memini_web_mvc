<?php

namespace Core\Router;

require_once __DIR__ . '/exceptions.php';

class Router
{
    private static array $routes = [];

    public static function addPathPattern(string $pathPattern, Callable $matcher): void
    {
        $pathPattern = preg_replace('/\//', '\\/', $pathPattern);
        $pathPattern = preg_replace('/{([a-z]+)}/', '(?P<\1>[a-z-]+)', $pathPattern);

        if (empty($pathPattern))
            $pathPattern = '(?![\s\S])';

        $pathPattern = "/^$pathPattern$/i";

        self::$routes[$pathPattern] = $matcher;
    }

    public static function addPath(string $path, Parameters $parameters): void
    {
        self::addPathPattern($path, fn($matches) => $parameters);
    }

    /**
     * @throws RouteNotFoundException
     * @throws ControllerNotFoundException
     * @throws ActionNotFoundException
     */
    public static function dispatch(string $path): void
    {
        $parameters = self::match($path);

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
    private static function match(string $path): Parameters
    {
        foreach (self::$routes as $pattern => $matcher)
            if (preg_match($pattern, $path, $matches))
                return $matcher($matches);

        throw new RouteNotFoundException($path);
    }
}
