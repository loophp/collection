<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function in_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Compact extends AbstractOperation implements Operation
{
    /**
     * @psalm-return Closure(T...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$values
             */
            static function (...$values): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($values): Generator {
                        $values = [] === $values ? [null] : $values;

                        /** @psalm-var callable(Iterator<TKey, T>):Generator<TKey, T> $filter */
                        $filter = Filter::of()(
                            /**
                             * @param mixed $value
                             * @psalm-param T $value
                             */
                            static function ($value) use ($values): bool {
                                return !in_array($value, $values, true);
                            }
                        );

                        return yield from $filter($iterator);
                    };
            };
    }
}
