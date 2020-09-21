<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation\Splitable;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Explode extends AbstractOperation
{
    /**
     * @psalm-return Closure(T...): Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$explodes
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, list<T>>
             */
            static function (...$explodes): Closure {
                /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, list<T>> $split */
                $split = Split::of()(Splitable::REMOVE)(
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
                );

                return $split;
            };
    }
}
