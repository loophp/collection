<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\ReduceIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Reduce extends AbstractOperation
{
    /**
     * @template V
     * @template W
     *
     * @return Closure(callable(mixed, mixed, mixed, iterable<mixed, mixed>): mixed): Closure(mixed): Closure(iterable<TKey, T>): Generator<TKey, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable((V|W), T, TKey, iterable<TKey, T>): W $callback
             *
             * @return Closure(V): Closure(iterable<TKey, T>): Generator<TKey, W>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param V $initial
                 *
                 * @return Closure(iterable<TKey, T>): Generator<TKey, W>
                 */
                static fn (mixed $initial): Closure =>
                    /**
                     * @param iterable<TKey, T> $iterable
                     *
                     * @return Generator<TKey, V>
                     */
                    static fn (iterable $iterable): Generator => yield from new ReduceIterableAggregate($iterable, $callback, $initial);
    }
}
