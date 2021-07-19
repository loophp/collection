<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Reduce extends AbstractOperation
{
    /**
     * @pure
     *
     * @template V
     *
     * @return Closure(callable(V, T, TKey, Iterator<TKey, T>): V): Closure (V): Closure(Iterator<TKey, T>): Generator<TKey, V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(V, T, TKey, Iterator<TKey, T>): V $callback
             *
             * @return Closure(V): Closure(Iterator<TKey, T>): Generator<TKey, V>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param V $initial
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<TKey, V>
                 */
                static function ($initial) use ($callback): Closure {
                    /** @var Closure(Iterator<TKey, T>): Generator<TKey, V> $pipe */
                    $pipe = Pipe::of()(
                        Reduction::of()($callback)($initial),
                        Last::of(),
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}
