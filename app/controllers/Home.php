<?php

namespace App\Controllers;

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../core/view/View.php';

use Core\Controller\Controller;
use Core\View\View;

class Home extends Controller
{
    public function indexAction(): void
    {
        View::render('home/index.php', ['name' => 'Felipe']);
    }
}
