<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router\ObjectRoute;
use Core\Router\Route;
use Core\Router\Router;

assert_options(ASSERT_BAIL, true);
session_start();

Router::addPath('', new Route('Home'));

Router::addPathPattern(
        '{controller}/{action}',
        fn($matches) => new Route($matches["controller"], $matches["action"])
);

Router::addPathPattern(
    '{controller}/{id:\d+}/{action}',
    fn($matches) => new ObjectRoute($matches["controller"], intval($matches["id"]), $matches["action"])
);

Router::addPathPattern(
    '{controller}',
    fn($matches) => new Route($matches["controller"])
);

$path = $_SERVER['QUERY_STRING'];

Router::dispatch($path);
