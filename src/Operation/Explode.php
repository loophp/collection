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
final class Explode extends AbstractOperation
{
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$explodes
             */
            static function (...$explodes): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int, list<T>>
                     */
                    static function (Iterator $iterator) use ($explodes): Generator {
                        return yield from Split::of()(
                            ...array_map(
                                /**
                                 * @param mixed $explode
                                 * @psalm-param T $explode
                                 */
                                static function ($explode): Closure {
                                    return
                                        /**
                                         * @param mixed $value
                                         * @psalm-param T $value
                                         */
                                        static function ($value) use ($explode): bool {
                                            return $value === $explode;
                                        };
                                },
                                $explodes
                            )
                        )($iterator);
                    };
            };
    }
}
