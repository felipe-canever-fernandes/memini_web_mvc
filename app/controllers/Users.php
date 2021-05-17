<?php

namespace App\Controllers;

use Core\Controller;
use Core\View\View;

class Users extends Controller
{
    public function indexAction(): void
    {
        View::render('users/index.twig');
    }
}
