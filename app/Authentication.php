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

        Router::redirect('/signin');
    }
}
