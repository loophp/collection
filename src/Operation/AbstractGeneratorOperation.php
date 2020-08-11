<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use loophp\collection\Iterator\ClosureIterator;

abstract class AbstractGeneratorOperation extends AbstractParametrizedOperation
{
    public function getWrapper(): Closure
    {
        return
            /**
             * @psalm-return ClosureIterator<TKey, T>
             */
            static function (callable $callable, ...$arguments): ClosureIterator {
                return new ClosureIterator($callable, ...$arguments);
            };
    }
}
