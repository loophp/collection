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
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Column extends AbstractOperation
{
    /**
     * @psalm-return Closure(T): Closure(Iterator<TKey, T>): Generator<int, iterable<TKey, T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param mixed $column
             * @psalm-param T $column
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, iterable<TKey, T>>
             */
            static function ($column): Closure {
                $filterCallbackBuilder =
                    /**
                     * @param mixed $column
                     * @psalm-param T $column
                     */
                    static fn ($column): Closure =>
                        /**
                         * @param mixed $value
                         * @psalm-param T $value
                         *
                         * @param mixed $key
                         * @psalm-param TKey $key
                         * @psalm-param Iterator<TKey, T> $iterator
                         */
                        static fn ($value, $key, Iterator $iterator): bool => $key === $column;

                /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, iterable<TKey, T>> $pipe */
                $pipe = Pipe::of()(
                    Transpose::of(),
                    Filter::of()($filterCallbackBuilder($column)),
                    Head::of(),
                    Unwrap::of()
                );

                // Point free style.
                return $pipe;
            };
    }
}
