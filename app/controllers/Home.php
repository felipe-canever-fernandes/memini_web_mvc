<?php

namespace App\Controllers;

use Core\Controller\Controller;
use Core\View\View;

class Home extends Controller
{
    public function indexAction(): void
    {
        View::render('home/index.twig', ['name' => 'Felipe']);
    }
}
