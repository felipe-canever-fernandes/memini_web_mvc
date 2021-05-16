<?php

namespace App\Controllers;

use Core\Controller;
use Core\View\View;

class Signin extends Controller
{
    public function indexAction(): void
    {
        View::render('signin/index.twig');
    }
}
