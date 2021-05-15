<?php

namespace Core\View;

class View
{
    public static function render(string $view): void
    {
        $file = __DIR__ . "/../../app/views/$view";

        if (!is_readable($file)) {
            echo "File '$file' not found.";
            return;
        }

        /** @noinspection PhpIncludeInspection */
        require $file;
    }
}
