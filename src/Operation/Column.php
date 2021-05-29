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
 * @template TKey
 * @template T
 */
final class Column extends AbstractOperation
{
    /**
     * @return Closure(T): Closure(Iterator<TKey, T>): Generator<int, iterable<TKey, T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T $column
             *
             * @return Closure(Iterator<TKey, T>): Generator<int, iterable<TKey, T>>
             */
            static function ($column): Closure {
                $filterCallbackBuilder =
                    /**
                     * @param T $column
                     */
                    static fn ($column): Closure =>
                        /**
                         * @param T $value
                         * @param TKey $key
                         * @param Iterator<TKey, T> $iterator
                         */
                        static fn ($value, $key, Iterator $iterator): bool => $key === $column;

                /** @var Closure(Iterator<TKey, T>): Generator<int, iterable<TKey, T>> $pipe */
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
