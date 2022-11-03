<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\MapIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Map extends AbstractOperation
{
    /**
     * @template V
     *
     * @return Closure(callable(T=, TKey=, iterable<TKey, T>=): mixed): Closure(iterable<TKey, T>): Generator<TKey, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=, iterable<TKey, T>=): V $callback
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<TKey, V>
                 */
                static fn (iterable $iterable): Generator => yield from new MapIterableAggregate($iterable, Closure::fromCallable($callback));
    }
}
