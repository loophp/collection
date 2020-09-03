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
final class Reduction extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T|null, T, TKey, Iterator<TKey, T>):(T|null)): Closure(T|null): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T|null, T, TKey, Iterator<TKey, T>):(T|null) $callback
             *
             * @psalm-return Closure(T|null): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (callable $callback): Closure {
                return
                    /**
                     * @param mixed|null $initial
                     * @psalm-param T|null $initial
                     *
                     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
                     */
                    static function ($initial = null) use ($callback): Closure {
                        return
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<TKey, T|null>
                             */
                            static function (Iterator $iterator) use ($callback, $initial): Generator {
                                foreach ($iterator as $key => $value) {
                                    yield $key => ($initial = $callback($initial, $value, $key));
                                }
                            };
                    };
            };
    }
}
