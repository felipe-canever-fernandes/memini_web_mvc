<?php

namespace Core\View;

require_once __DIR__ . '/exceptions.php';

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Loader\FilesystemLoader;

use App\Authentication;

class View
{
    private static ?Environment $twig = null;

    /**
     * @throws ViewNotFoundException
     */
    public static function render(string $view, array $arguments = []): void
    {
        if (!self::$twig) {
            $loader = new FilesystemLoader(__DIR__ . '/../../app/views');
            self::$twig = new Environment($loader);

            self::$twig->addGlobal('signedInUser', Authentication::getSignedInUser());
        }

        try {
            echo self::$twig->render($view, $arguments);
        } catch (LoaderError $error) {
            throw new ViewNotFoundException($view);
        }
    }
}
