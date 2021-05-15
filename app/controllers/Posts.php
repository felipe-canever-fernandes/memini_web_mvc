<?php

namespace App\Controllers;

require_once __DIR__ . '/../../core/controller/Controller.php';

use Core\Controller\Controller;

class Posts extends Controller
{
    public function indexAction(): void
    {
        echo 'Hello, posts!';
    }

    public function newAction(): void
    {
        echo 'New Post';
    }
}
