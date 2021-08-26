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
 */
final class Column extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(mixed): Closure(Iterator<TKey, T>): Generator<int, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param mixed $column
             *
             * @return Closure(Iterator<TKey, T>): Generator<int, mixed>
             */
            static function ($column): Closure {
                $filterCallbackBuilder =
                    /**
                     * @param mixed $column
                     */
                    static fn ($column): Closure =>
                        /**
                         * @param T $value
                         * @param TKey $key
                         * @param Iterator<TKey, T> $iterator
                         */
                        static fn ($value, $key, Iterator $iterator): bool => $key === $column;

                /** @var Closure(Iterator<TKey, T>): Generator<int, mixed> $pipe */
                $pipe = Pipe::of()(
                    Transpose::of(),
                    (new Filter())()($filterCallbackBuilder($column)),
                    Head::of(),
                    Flatten::of()(1)
                );

                // Point free style.
                return $pipe;
            };
    }
}
