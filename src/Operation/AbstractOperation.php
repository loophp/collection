<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;

abstract class AbstractOperation extends AbstractParametrizedOperation
{
    public function getWrapper(): Closure
    {
        return static function (callable $callable, ...$arguments) {
            return ($callable)(...$arguments);
        };
    }
}
