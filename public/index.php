<?php

assert_options(ASSERT_BAIL, true);

require_once '../app/controllers/Home.php';
require_once '../core/router/Router.php';

use Core\Router\ActionNotFoundException;
use Core\Router\ControllerNotFoundException;
use Core\Router\Parameters;
use Core\Router\RouteNotFoundException;
use Core\Router\Router;

$router = new Router();

$router->addPath('', new Parameters('Home'));
$router->addPath('posts', new Parameters('Posts'));
$router->addPath('posts/create', new Parameters('Posts', 'create'));

$router->addPathPattern(
        '{controller}/{action}',
        fn($matches) => new Parameters($matches["controller"], $matches["action"])
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Memini</title>
</head>
<body>
	<h1>Hello, Memini!</h1>

    <?php

    $path = $_SERVER['QUERY_STRING'];

    try {
        $router->dispatch($path);
    } catch (RouteNotFoundException | ControllerNotFoundException | ActionNotFoundException $exception) {
        echo $exception->getMessage();
    }

    ?>
</body>
</html>
