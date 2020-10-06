<?php

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
                     * @psalm-param T $column
                     *
                     * @param mixed $column
                     */
                    static function ($column): Closure {
                        return
                            /**
                             * @psalm-param T $value
                             * @psalm-param TKey $key
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @param mixed $value
                             * @param mixed $key
                             */
                            static function ($value, $key, Iterator $iterator) use ($column): bool {
                                return $key === $column;
                            };
                    };

                /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, iterable<TKey, T>> $pipe */
                $pipe = Pipe::of()(
                    Transpose::of(),
                    Filter::of()($filterCallbackBuilder($column)),
                    First::of(),
                    Unwrap::of()
                );

                // Point free style.
                return $pipe;
            };
    }
}
