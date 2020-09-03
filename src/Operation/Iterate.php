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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Iterate extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T...):(array<TKey, T>)): Closure(T...): Closure(Iterator<TKey, T>=): Generator<int, T|false, mixed, void>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T...):(array<TKey, T>) $callback
             *
             * @psalm-return Closure(T...): Closure(Iterator<TKey, T>=): Generator<int, T|false, mixed, void>
             */
            static function (callable $callback): Closure {
                return
                    /**
                     * @psalm-param T ...$parameters
                     *
                     * @psalm-return Closure(Iterator<TKey, T>=): Generator<int, T|false, mixed, void>
                     */
                    static function (...$parameters) use ($callback): Closure {
                        return
                            /**
                             * @psalm-param null|Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<int, T|false, mixed, void>
                             */
                            static function (?Iterator $iterator = null) use ($callback, $parameters): Generator {
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
