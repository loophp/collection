<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

abstract class AbstractEagerOperation extends AbstractOperation
{
    public function call(callable $callable, ...$arguments)
    {
        return $callable(...$arguments);
    }
}
