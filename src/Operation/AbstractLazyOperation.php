<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Iterator;
use loophp\collection\Iterator\ClosureIterator;

abstract class AbstractLazyOperation extends AbstractOperation
{
    public function call(callable $callable, ...$arguments): Iterator
    {
        return new ClosureIterator($callable, ...$arguments);
    }
}
