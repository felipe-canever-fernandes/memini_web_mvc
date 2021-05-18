<?php

namespace App\Controllers;

use App\Authentication;
use App\Models\User\User;
use Core\Controller;
use Core\Router\Router;
use Core\View\View;

class Home extends Controller
{
    public function indexAction(): void
    {
        if (Authentication::isUserSignedIn())
            Router::redirect('/decks');

        View::render('home/index.twig');
    }
}
