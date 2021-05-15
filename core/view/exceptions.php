<?php

namespace Core\View;

use Exception;
use Throwable;

class ViewNotFoundException extends Exception
{
    public function __construct(string $view, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("View '$view' not found.", $code, $previous);
    }
}
