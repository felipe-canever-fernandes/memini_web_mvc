<?php

require_once __DIR__ . '/../vendor/autoload.php';

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
    '{controller}',
    fn($matches) => new Route($matches["controller"])
);

$path = $_SERVER['QUERY_STRING'];

Router::dispatch($path);
