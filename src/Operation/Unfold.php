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
final class Unfold extends AbstractOperation
{
    /**
     * @psalm-return Closure(T): Closure(callable(T):T): Closure(Iterator<TKey, T>=): Generator<int, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T $init
             *
             * @psalm-return Closure(callable(T):T): Closure(Iterator<TKey, T>=): Generator<int, T>
             *
             * @param mixed $init
             */
            static function ($init): Closure {
                return
                    /**
                     * @psalm-param callable(T): T $callback
                     *
                     * @psalm-return Closure(Iterator<TKey, T>=): Generator<T, T>
                     */
                    static function (callable $callback) use ($init): Closure {
                        return
                            /**
                             * @psalm-param null|Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<T, T>
                             */
                            static function (?Iterator $iterator = null) use ($init, $callback): Generator {
                                $loop =
                                    /**
                                     * @psalm-param T $init
                                     * @psalm-param callable(T): T $callback
                                     *
                                     * @psalm-return Generator<T, T>
                                     *
                                     * @param mixed $init
                                     */
                                    static function ($init, callable $callback) use (&$loop): Generator {
                                        yield $init => $init;

                                        return yield from $loop($callback($init), $callback);
                                    };

                                return yield from $loop($init, $callback);
                            };
                    };
            };
    }
}
