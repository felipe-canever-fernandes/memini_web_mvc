<?php

namespace App\Controllers;

use App\Models\Post;

use Core\Controller;
use Core\View\View;

class Posts extends Controller
{
    public function indexAction(): void
    {
        View::render('posts/index.twig', ['posts' => Post::getAll()]);
    }

    public function newAction(): void
    {
        View::render('posts/new.twig');
    }
}
