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
final class Prepend extends AbstractOperation
{
    /**
     * @template U
     *
     * @return Closure(array<U>): Closure(iterable<TKey, T>): iterable<int|TKey, T|U>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param array<U> $items
             *
             * @return Closure(iterable<TKey, T>): iterable<int|TKey, T|U>
             */
            static fn (array $items): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<int|TKey, T|U>
                 */
                static fn (iterable $iterable): Generator => yield from new ConcatIterableAggregate([$items, $iterable]);
    }
}
