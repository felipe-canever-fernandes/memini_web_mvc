<?php

namespace Core\Controller;

require_once 'exceptions.php';

abstract class Controller
{
    public const ACTION_SUFFIX = "Action";

    /**
     * @throws MethodNotFoundException
     */
    public function __call($name, $arguments): void
    {
        $method =  $name . self::ACTION_SUFFIX;

        if (!method_exists($this, $method))
            throw new MethodNotFoundException(self::class . $method);

        call_user_func_array([$this, $method], $arguments);
    }
}
