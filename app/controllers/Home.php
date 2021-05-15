<?php

namespace App\Controllers;

require_once __DIR__ . '/../../core/controller/Controller.php';

use Core\Controller\Controller;

class Home extends Controller
{
    public function indexAction(): void
    {
        echo 'Hello, world!';
    }
}
