<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Iterator\MultipleIterableIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Append extends AbstractOperation
{
    /**
     * @psalm-return Closure(T...): Closure(Iterator<TKey, T>): Iterator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$items
             *
             * @psalm-return Closure(Iterator<TKey, T>): Iterator<int|TKey, T>
             */
            static fn (...$items): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Iterator<int|TKey, T>
                 */
                static fn (Iterator $iterator): Iterator => new MultipleIterableIterator($iterator, $items);
    }
}
