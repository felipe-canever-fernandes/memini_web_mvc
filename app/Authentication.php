<?php

namespace App;

use App\Models\User\User;
use Core\Router\Router;

class Authentication
{
    public static function signIn(User $user): void
    {
        $_SESSION['userId'] = $user->getId();
    }

    public static function signOut(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function isUserSignedIn(): bool
    {
        return isset($_SESSION['userId']);
    }

    public static function getSignedInUser()
    {
        if (!self::isUserSignedIn())
            return false;

        $result = User::findById(intval($_SESSION['userId']));

        if (!$result)
            return false;

        return $result;
    }

    public static function requestSignin(): void
    {
        if (self::isUserSignedIn())
            return;

        self::saveRequestedPage();
        Router::redirect('/signin');
    }

    private static function saveRequestedPage(): void
    {
        $_SESSION['requestedPage'] = $_SERVER['REQUEST_URI'];
    }

    public static function getRequestedPage(): string
    {
        return $_SESSION['requestedPage'] ?? '/';
    }
}
