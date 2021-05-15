<?php

namespace Core\View;

use Throwable;
use Core\NotFoundException;

class ViewNotFoundException extends NotFoundException
{
    public function __construct(string $view, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("view", $view, $code, $previous);
    }
}
