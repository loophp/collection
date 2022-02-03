<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class When extends AbstractOperation
{
    /**
     * @return Closure(callable(iterable<TKey, T>): bool): Closure(callable(iterable<TKey, T>): iterable<TKey, T>): Closure(callable(iterable<TKey, T>): iterable<TKey, T>): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(iterable<TKey, T>): bool $predicate
             *
             * @return Closure(callable(iterable<TKey, T>): iterable<TKey, T>): Closure(callable(iterable<TKey, T>): iterable<TKey, T>): Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (callable $predicate): Closure =>
                /**
                 * @param callable(iterable<TKey, T>): iterable<TKey, T> $whenTrue
                 *
                 * @return Closure(callable(iterable<TKey, T>): iterable<TKey, T>): Closure(iterable<TKey, T>): Generator<TKey, T>
                 */
                static fn (callable $whenTrue): Closure =>
                    /**
                     * @param callable(iterable<TKey, T>): iterable<TKey, T> $whenFalse
                     *
                     * @return Closure(iterable<TKey, T>): Generator<TKey, T>
                     */
                    static fn (callable $whenFalse): Closure =>
                        /**
                         * @param iterable<TKey, T> $iterable
                         *
                         * @return Generator<TKey, T>
                         */
                        static fn (iterable $iterable): Generator => yield from $predicate($iterable) ? $whenTrue($iterable) : $whenFalse($iterable);
    }
}
