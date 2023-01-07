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
final class FoldRight extends AbstractOperation
{
    /**
     * @template V
     *
     * @return Closure(callable(V, T, TKey, iterable<TKey, T>): V): Closure(V): Closure(iterable<TKey, T>): Generator<int, V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(V, T, TKey, iterable<TKey, T>): V $callback
             *
             * @return Closure(V): Closure(iterable<TKey, T>): Generator<int, V>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param V $initial
                 *
                 * @return Closure(iterable<TKey, T>): Generator<int, V>
                 */
                static function (mixed $initial = null) use ($callback): Closure {
                    /** @var Closure(iterable<TKey, T>): Generator<int, V> $pipe */
                    $pipe = (new Pipe())()(
                        (new ScanRight())()($callback)($initial),
                        (new Head())()
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}
