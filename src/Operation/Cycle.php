<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use InfiniteIterator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Cycle extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Iterator<TKey, T>
             */
            static fn (Iterator $iterator): Iterator => new InfiniteIterator($iterator);
    }
}
