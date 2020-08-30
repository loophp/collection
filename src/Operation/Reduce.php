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
final class Reduce extends AbstractOperation
{
    // phpcs:disable
    /**
     * @psalm-return Closure(callable(T|null, T, TKey, Iterator<TKey, T>): T): Closure(T|null): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    // phpcs:enable
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T|null, T, TKey, Iterator<TKey, T>): T $callback
             *
             * @psalm-return Closure(T|null): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (callable $callback): Closure {
                return
                    /**
                     * @psalm-param T|null $initial
                     *
                     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
                     *
                     * @param mixed|null $initial
                     */
                    static function ($initial = null) use ($callback): Closure {
                        return
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<TKey, T>
                             */
                            static function (Iterator $iterator) use ($callback, $initial): Generator {
                                return yield from FoldLeft::of()($callback)($initial)($iterator);
                            };
                    };
            };
    }
}
