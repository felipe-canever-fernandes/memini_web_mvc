<?php

assert_options(ASSERT_BAIL, true);

require_once '../app/controllers/Home.php';
require_once '../app/controllers/Posts.php';

require_once '../core/router/Router.php';

use Core\Router\ActionNotFoundException;
use Core\Router\ControllerNotFoundException;
use Core\Router\Parameters;
use Core\Router\RouteNotFoundException;
use Core\Router\Router;

$router = new Router();

$router->addPath('', new Parameters('Home'));

$router->addPathPattern(
        '{controller}/{action}',
        fn($matches) => new Parameters($matches["controller"], $matches["action"])
);

$path = $_SERVER['QUERY_STRING'];

try {
    $router->dispatch($path);
} catch (RouteNotFoundException | ControllerNotFoundException | ActionNotFoundException $exception) {
    echo $exception->getMessage();
}
