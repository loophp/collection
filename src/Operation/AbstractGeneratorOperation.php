<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use loophp\collection\Iterator\ClosureIterator;

abstract class AbstractGeneratorOperation extends AbstractParametrizedOperation
{
    public function getWrapper(): Closure
    {
        return static function (callable $callable, ...$arguments) {
            return new ClosureIterator($callable, ...$arguments);
        };
    }
}
