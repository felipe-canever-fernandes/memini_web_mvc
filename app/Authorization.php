<?php

namespace App;

use Core\Router\Router;

class Authorization
{
    public static function request(): void
    {
        $signedInUser = Authentication::getSignedInUser();

        if ($signedInUser != false && $signedInUser->isAdministrator())
            return;

        Router::redirect('/error/forbidden');
    }
}
