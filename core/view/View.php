<?php

namespace Core\View;

require_once __DIR__ . '/exceptions.php';

class View
{
    /**
     * @throws ViewNotFoundException
     */
    public static function render(string $view, array $arguments = []): void
    {
        $file = __DIR__ . "/../../app/views/$view";

        if (!is_readable($file))
            throw new ViewNotFoundException($view);

        extract($arguments, EXTR_SKIP);

        /** @noinspection PhpIncludeInspection */
        require $file;
    }
}
