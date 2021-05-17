<?php

namespace Core\Router;

use MongoDB\BSON\ObjectId;

require_once __DIR__ . '/exceptions.php';

class Router
{
    private static array $routes = [];

    public static function addPathPattern(string $pathPattern, Callable $matcher): void
    {
        $pathPattern = preg_replace('/\//', '\\/', $pathPattern);
        $pathPattern = preg_replace('/{([a-z]+):(.+?)}/', '(?P<\1>\2)', $pathPattern);
        $pathPattern = preg_replace('/{([a-z]+)}/', '(?P<\1>[a-z-]+)', $pathPattern);

        if (empty($pathPattern))
            $pathPattern = '(?![\s\S])';

        $pathPattern = "/^$pathPattern$/i";

        self::$routes[$pathPattern] = $matcher;
    }

    public static function addPath(string $path, Route $route): void
    {
        self::addPathPattern($path, fn($matches) => $route);
    }

    /**
     * @throws RouteNotFoundException
     * @throws ControllerNotFoundException
     * @throws ActionNotFoundException
     */
    public static function dispatch(string $path): void
    {
        $route = self::match($path);

        $Controller = "\\App\\Controllers\\{$route->getController()}";

        if (!class_exists($Controller))
            throw new ControllerNotFoundException($Controller);

        $controller = new $Controller;

        $action = $route->getAction();

        if (!$controller->actionExists($action))
            throw new ActionNotFoundException("$Controller::$action");

        if (!($route instanceof ObjectRoute))
            $controller->$action();
        else
            $controller->$action($route->getId());
    }

    public static function redirect(string $path): void
    {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $path, true, 303);
        exit;
    }

    /**
     * @throws RouteNotFoundException
     */
    private static function match(string $path): Route
    {
        foreach (self::$routes as $pattern => $matcher)
            if (preg_match($pattern, $path, $matches))
                return $matcher($matches);

        throw new RouteNotFoundException($path);
    }
}
