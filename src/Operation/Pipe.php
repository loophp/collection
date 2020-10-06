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
final class Pipe extends AbstractOperation
{
    /**
     * @psalm-return Closure((callable(Iterator<TKey, T>):Generator<TKey, T>)...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(Iterator<TKey, T>): Generator<TKey, T> ...$operations
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (callable ...$operations): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
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
