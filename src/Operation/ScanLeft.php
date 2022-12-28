<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\ReductionIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class ScanLeft extends AbstractOperation
{
    /**
     * @template V
     *
     * @return Closure(callable(mixed, mixed, mixed, iterable<mixed, mixed>): mixed): Closure(mixed): Closure(iterable<TKey, T>): Generator<TKey|int, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(V, T, TKey, iterable<TKey, T>): V $callback
             *
             * @return Closure(V): Closure(iterable<TKey, T>): Generator<TKey|int, V>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param V $initial
                 *
                 * @return Closure(iterable<TKey, T>): Generator<TKey|int, V>
                 */
                static fn (mixed $initial): Closure =>
                    /**
                     * @param iterable<TKey, T> $iterable
                     *
                     * @return Generator<TKey|int, V>
                     */
                    static fn (iterable $iterable): Generator => yield from new ReductionIterableAggregate($iterable, Closure::fromCallable($callback), $initial);
    }
}
