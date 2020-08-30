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
final class Iterate extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T...):(array<TKey, T>)): Closure(T...): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T...):(array<TKey, T>) $callback
             */
            static function (callable $callback): Closure {
                return
                    /**
                     * @psalm-param T ...$parameters
                     */
                    static function (...$parameters) use ($callback): Closure {
                        return
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<TKey, T>
                             */
                            static function (Iterator $iterator) use ($callback, $parameters): Generator {
                                while (true) {
                                    yield current(
                                        $parameters = (array) $callback(...array_values((array) $parameters))
                                    );
                                }
                            };
                    };
            };
    }
}
