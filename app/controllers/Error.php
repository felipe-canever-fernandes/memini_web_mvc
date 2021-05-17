<?php

namespace App\Controllers;

use Core\Controller;
use Core\View\View;

class Error extends Controller
{
    public function forbiddenAction(): void
    {
        View::render('error/forbidden.twig');
    }

    public function notFoundAction(): void
    {
        View::render('error/not-found.twig');
    }
}
