<?php

namespace App\Controllers;

use App\Models\User\User;
use App\Models\ValidationErrorException;
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
        $result = User::authenticate($_POST['email'], $_POST['password']);

        if ($result instanceof User) {
            $result->setHashedPassword('');
            $_SESSION['user'] = $result;

            Router::redirect('/');
        }
        else
            View::render('signin/index.twig', [
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'errors' => $result
            ]);
    }
}
