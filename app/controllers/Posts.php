<?php

namespace App\Controllers;

class Posts
{
    public function indexAction(): void
    {
        echo 'Hello, posts!';
    }

    public function newAction(): void
    {
        echo 'New Post';
    }
}
