<?php

namespace App\Controllers;

use App\Authorization;
use App\Models\User\User;
use Core\Controller;
use Core\View\View;

class Users extends Controller
{
    public function doBefore(): bool
    {
        Authorization::request();
        return true;
    }

    public function indexAction(): void
    {
        View::render('users/index.twig', ['users' => User::findAll()]);
    }

    public function newAction(): void
    {
        View::render('users/new.twig');
    }
}
