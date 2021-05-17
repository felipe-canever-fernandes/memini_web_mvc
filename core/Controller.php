<?php

namespace Core;

abstract class Controller
{
    private const ACTION_SUFFIX = "Action";

    public final static function actionToMethod(string $action): string
    {
        return $action . self::ACTION_SUFFIX;
    }

    public final function __call(string $name, array $arguments): void
    {
        $method =  self::actionToMethod($name);

        if (!$this->doBefore())
            return;

        call_user_func_array([$this, $method], $arguments);

        $this->doAfter();
    }

    public final function actionExists(string $action): bool
    {
        return method_exists($this, self::actionToMethod($action));
    }

    public function doBefore(): bool
    {
        return true;
    }

    public function doAfter(): void {}
}
