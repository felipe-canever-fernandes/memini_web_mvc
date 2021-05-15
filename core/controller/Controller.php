<?php

namespace Core\Controller;

require_once 'exceptions.php';

abstract class Controller
{
    private const ACTION_SUFFIX = "Action";

    public final static function actionToMethod(string $action): string
    {
        return $action . self::ACTION_SUFFIX;
    }

    /**
     * @throws MethodNotFoundException
     */
    public final function __call($name, $arguments): void
    {
        $method =  self::actionToMethod($name);

        if (!$this->actionExists($name))
            throw new MethodNotFoundException(self::class . $method);

        if (!self::doBefore())
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
