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
final class Compose extends AbstractOperation
{
    // phpcs:disable
    /**
     * @psalm-return Closure((callable(Iterator<TKey, T>):Generator<TKey, T>)...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    // phpcs:enable
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(Iterator<TKey, T>): Generator<TKey, T> ...$operations
             */
            static function (callable ...$operations): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($operations): Generator {
                        $callback =
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             * @psalm-param callable(Iterator<TKey, T>): Generator<TKey, T> $fn
                             *
                             * @psalm-return Generator<TKey, T>
                             */
                            static function (Iterator $iterator, callable $fn): Generator {
                                return $fn($iterator);
                            };

                        return yield from array_reduce($operations, $callback, $iterator);
                    };
            };
    }
}
