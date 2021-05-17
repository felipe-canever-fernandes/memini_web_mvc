<?php

namespace App\Controllers;

use App\Authentication;
use App\Models\User\User;
use Core\Controller;
use Core\Router\Router;
use Core\View\View;

class Signin extends Controller
{
    public function indexAction(): void
    {
        View::render('signin/index.twig');
    }

    public function readAction(): void
    {
        if (!isset($_POST['signin']))
            Router::redirect('/signin');

        $result = User::authenticate($_POST['email'], $_POST['password']);

        if ($result instanceof User) {
            Authentication::signIn($result);
            Router::redirect(Authentication::getRequestedPage());
        }
        else
            View::render('signin/index.twig', [
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'errors' => $result
            ]);
    }

    public function signoutAction(): void
    {
        Authentication::signOut();
        Router::redirect('/');
    }
}
