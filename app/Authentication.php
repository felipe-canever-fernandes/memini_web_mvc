<?php

namespace App;

use App\Models\User\User;

class Authentication
{
    public static function signIn(User $user): void
    {
        $user->setHashedPassword('');
        $_SESSION['user'] = $user;
    }

    public static function signOut(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
