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
     * @psalm-return Closure(Iterator<TKey, T>, array-key):(Generator<int, iterable<TKey, T>>)
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param int|string $column
             *
             * @psalm-param array-key $column
             */
            static function ($column): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int, iterable<TKey, T>>
                     */
                    static function (Iterator $iterator) use ($column): Generator {
                        /**
                         * @psalm-var array-key $key
                         * @psalm-var iterable<TKey, T> $value
                         */
                        foreach (Transpose::of()($iterator) as $key => $value) {
                            if ($key === $column) {
                                return yield from $value;
                            }
                        }
                    };
            };
    }
}
