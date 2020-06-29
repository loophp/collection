<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InfiniteIterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

final class Loop extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (iterable $collection): Generator {
            foreach (new InfiniteIterator(new IterableIterator($collection)) as $value) {
                yield $value;
            }
        };
    }
}
