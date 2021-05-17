<?php

namespace App\Controllers;

use App\Authorization;
use App\Models\User\User;
use App\Models\ValidationErrorException;
use Core\Controller;
use Core\Router\Router;
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

    public function createAction(): void
    {
        if (!isset($_POST['create']))
            Router::redirect('/users/new');

        $user = new User(
            $_POST['name'],
            $_POST['email'],
            $_POST['password'],
            false,
            isset($_POST['isAdministrator'])
        );

        try {
            User::save($user);
            Router::redirect('/users');
        } catch (ValidationErrorException $exception) {
            View::render('users/new.twig', [
                'user' => $user,
                'errors' => $exception->getErrors()
            ]);
        }
    }

    public function editAction(int $id)
    {
        View::render('users/edit.twig', ['user' => User::findById($id)]);
    }
}
