<?php

assert_options(ASSERT_BAIL, true);

require_once __DIR__ . '/../vendor/autoload.php';

require_once '../app/controllers/Home.php';
require_once '../app/controllers/Posts.php';

require_once '../core/router/Router.php';

use Core\Router\Parameters;
use Core\Router\Router;

$router = new Router();

$router->addPath('', new Parameters('Home'));

$router->addPathPattern(
        '{controller}/{action}',
        fn($matches) => new Parameters($matches["controller"], $matches["action"])
);

$path = $_SERVER['QUERY_STRING'];

$router->dispatch($path);
