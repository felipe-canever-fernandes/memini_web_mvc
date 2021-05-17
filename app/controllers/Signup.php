<?php

namespace App\Controllers;

use App\Authentication;
use App\Models\User\User;
use App\Models\ValidationErrorException;
use Core\Controller;
use Core\Router\Router;
use Core\View\View;

class Signup extends Controller
{
    public function indexAction(): void
    {
        View::render('signup/index.twig');
    }

    public function insertAction(): void
    {
        if (!isset($_POST['signup']))
            Router::redirect('/signup');

        $user = new User($_POST['name'], $_POST['email'], $_POST['password'], false, false);

        try {
            User::save($user);
            Authentication::signIn($user);
            Router::redirect('/');
        } catch (ValidationErrorException $exception) {
            View::render('signup/index.twig', [
                'user' => $user,
                'errors' => $exception->getErrors()
            ]);
        }
    }
}
