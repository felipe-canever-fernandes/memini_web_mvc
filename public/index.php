<?php

assert_options(ASSERT_BAIL, true);

require_once '../core/router/Router.php';

use Core\Router\Parameters;
use Core\Router\Router;

$router = new Router();

$router->add('', new Parameters('Home'));
$router->add('posts', new Parameters('Posts'));
$router->add('posts/create', new Parameters('Posts', 'create'));

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

    <h2>Routes</h2>

    <?php

    $path = $_SERVER['QUERY_STRING'];

    try {
        var_dump($router->match($path));
    } catch (OutOfBoundsException $exception) {
        echo $exception->getMessage();
    }

    ?>
</body>
</html>
