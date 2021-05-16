<?php

namespace App\Controllers;

use App\Models\Post;

use Core\Controller;
use Core\View\View;

class Signup extends Controller
{
    public function indexAction(): void
    {
        View::render('signup/index.twig');
    }
}
