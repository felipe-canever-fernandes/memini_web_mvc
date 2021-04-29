<?php

require_once "../core/Router.php";

use Core\Router;
$router = new Router();

$router->add('', [
        'controller'    => 'Home',
        'action'        => 'index'
]);

$router->add('posts', [
        'controller'    => 'Posts',
        'action'        => 'index'
]);

$router->add('posts/create', [
        'controller'    => 'Posts',
        'action'        => 'create'
]);

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
    var_dump($router->getRoutes());
    ?>
</body>
</html>
