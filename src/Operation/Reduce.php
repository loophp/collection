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
     * @return Closure(callable((T|null), T, TKey, Iterator<TKey, T>): (T|null)):Closure (T|null): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T|null, T, TKey, Iterator<TKey, T>):(T|null) $callback
             *
             * @return Closure(T|null): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param T|null $initial
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
                 */
                static function ($initial = null) use ($callback): Closure {
                    /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
                    $pipe = Pipe::of()(
                        Reduction::of()($callback)($initial),
                        Last::of(),
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}
