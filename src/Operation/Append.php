<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\ConcatIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Append extends AbstractOperation
{
    /**
     * @return Closure(array<T>): Closure(iterable<TKey, T>): Generator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param array<T> $items
             *
             * @return Closure(iterable<TKey, T>): Generator<int|TKey, T>
             */
            static fn (array $items): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<int|TKey, T>
                 */
                static fn (iterable $iterable): Generator => yield from new ConcatIterableAggregate([$iterable, $items]);
    }
}
