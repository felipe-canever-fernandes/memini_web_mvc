<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router\Parameters;
use Core\Router\Router;

assert_options(ASSERT_BAIL, true);
session_start();

Router::addPath('', new Parameters('Home'));

Router::addPathPattern(
        '{controller}/{action}',
        fn($matches) => new Parameters($matches["controller"], $matches["action"])
);

Router::addPathPattern(
    '{controller}',
    fn($matches) => new Parameters($matches["controller"])
);

$path = $_SERVER['QUERY_STRING'];

Router::dispatch($path);
