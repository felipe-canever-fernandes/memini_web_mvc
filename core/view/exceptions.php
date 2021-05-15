<?php

namespace Core\View;

require_once __DIR__ . '/../exceptions.php';

use Throwable;
use Core\NotFoundException;

class ViewNotFoundException extends NotFoundException
{
    public function __construct(string $view, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("view", $view, $code, $previous);
    }
}
