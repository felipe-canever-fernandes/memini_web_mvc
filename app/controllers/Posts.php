<?php

namespace App\Controllers;

class Posts
{
    public static function indexAction(): void
    {
        echo 'Hello, posts!';
    }

    public static function newAction(): void
    {
        echo 'New Post';
    }
}
