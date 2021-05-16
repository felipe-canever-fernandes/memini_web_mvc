<?php

namespace App\Controllers;

use App\Models\User;
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
        $user = new User(
            $_POST['name'],
            $_POST['email'],
            password_hash($_POST['password'], PASSWORD_DEFAULT)
        );

        User::insert($user);
    }
}
