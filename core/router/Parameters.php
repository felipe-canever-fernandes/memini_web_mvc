<?php

namespace Core\Router;

class Parameters
{
    private string $controller;
    private string $action;

    public function __construct(string $controller, string $action = 'index')
    {
        $this->controller = self::validateController($controller);
        $this->action = self::validateAction($action);
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    private static function validateParameter(string $parameter): string
    {
        assert(!empty($parameter));
        return $parameter;
    }

    private static function validateController(string $controller): string
    {
        return self::toPascalCase(self::validateParameter($controller));
    }

    private static function validateAction(string $action): string
    {
        return self::toCamelCase(self::validateParameter($action));
    }

    private static function toPascalCase(string $string): string
    {
        $words = str_replace('-', ' ', $string);
        $capitalized = ucwords($words);
        return str_replace(' ', '', $capitalized);
    }

    private static function toCamelCase(string $string): string
    {
        return lcfirst(self::toPascalCase($string));
    }
}
