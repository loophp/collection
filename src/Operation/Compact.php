<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use function in_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Compact extends AbstractOperation
{
    /**
     * @psalm-return Closure(T...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$values
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (...$values): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($values): Generator {
                        $filterCallback = static function (array $values): Closure {
                            return static function ($value) use ($values): bool {
                                return !in_array($value, $values, true);
                            };
                        };

                        /** @psalm-var callable(Iterator<TKey, T>):Generator<TKey, T> $filter */
                        $filter = Filter::of()($filterCallback([] === $values ? [null] : $values));

                        return yield from $filter($iterator);
                    };
            };
    }
}
