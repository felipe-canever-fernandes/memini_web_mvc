<?php

namespace Core\Router;

class ObjectRoute extends Route
{
    private int $id;

    public function __construct(string $controller, int $id, string $action = 'index')
    {
        parent::__construct($controller, $action);
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
