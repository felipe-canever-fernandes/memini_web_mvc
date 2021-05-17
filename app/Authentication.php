<?php

namespace App;

use App\Models\User\User;

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

    public static function getSignedInUser()
    {
        if (!isset($_SESSION['userId']))
            return false;

        $result = User::findById(intval($_SESSION['userId']));

        if (!$result)
            return false;

        return $result;
    }
}
