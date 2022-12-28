<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class ScanRight extends AbstractOperation
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
                static function (mixed $initial) use ($callback): Closure {
                    /** @var Closure(iterable<TKey, T>): Generator<TKey|int, V> $pipe */
                    $pipe = (new Pipe())()(
                        (new Reverse())(),
                        (new ScanLeft())()($callback)($initial),
                        (new Reverse())()
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}
