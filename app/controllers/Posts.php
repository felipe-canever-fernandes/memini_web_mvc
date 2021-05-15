<?php

namespace App\Controllers;

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../core/view/View.php';

use Core\Controller\Controller;
use Core\View\View;

class Posts extends Controller
{
    public function indexAction(): void
    {
        View::render('posts/index.twig');
    }

    public function newAction(): void
    {
        View::render('posts/new.twig');
    }
}
