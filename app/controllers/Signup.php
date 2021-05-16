<?php

namespace App\Controllers;

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
        $user = new User($_POST['name'], $_POST['email'], $_POST['password'], false);

        try {
            User::insert($user);
            Router::redirect('/signup/success');
        } catch (ValidationErrorException $exception) {
            View::render('signup/index.twig', [
                'user' => $user,
                'errors' => $exception->getErrors()
            ]);
        }
    }

    public function successAction(): void
    {
        View::render('signup/success.twig');
    }
}
