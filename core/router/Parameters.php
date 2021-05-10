<?php

namespace Core\Router;

class Parameters
{
    private string $controller;
    private string $action;

    public function __construct(string $controller, string $action = 'index')
    {
        $this->controller = self::validateController($controller);
        $this->action = self::validateParameter($action);
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function setController(string $controller): void
    {
        $this->controller = self::validateController($controller);
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        $this->action = self::validateParameter($action);
    }

    private static function validateParameter(string $parameter): string
    {
        assert(!empty($parameter));
        return $parameter;
    }

    private static function validateController(string $controller): string
    {
        return ucfirst(self::validateParameter($controller));
    }
}
