<?php

namespace App;

use Core\Router\Router;

class Authorization
{
    public static function request(): void
    {
        if (Authentication::getSignedInUser()->isAdministrator())
            return;

        Router::redirect('/error/forbidden');
    }
}
