<?php

namespace App\Controllers;

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
