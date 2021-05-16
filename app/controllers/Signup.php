<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\ValidationErrorException;
use Core\Controller;
use Core\View\View;

class Signup extends Controller
{
    public function indexAction(): void
    {
        View::render('signup/index.twig');
    }

    public function insertAction(): void
    {
        $user = new User($_POST['name'], $_POST['email'], $_POST['password']);

        try {
            User::insert($user);
            View::render('signup/success.twig');
        } catch (ValidationErrorException $exception) {
            View::render('signup/index.twig', ['errors' => $exception->getErrors()]);
        }
    }
}
