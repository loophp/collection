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
final class Reduction extends AbstractOperation
{
    // phpcs:disable
    /**
     * @psalm-return Closure(callable(T|null, T, TKey):(T|null)): Closure(T|null): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    // phpcs:enable
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T|null, T, TKey):(T|null) $callback
             */
            static function (callable $callback): Closure {
                return
                    /**
                     * @param mixed|null $initial
                     * @psalm-param T|null $initial
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
