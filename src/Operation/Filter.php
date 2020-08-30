<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use CallbackFilterIterator;
use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Filter extends AbstractOperation
{
    // phpcs:disable
    /**
     * @psalm-return Closure((callable(T, TKey, Iterator<TKey, T>): bool)...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    // phpcs:enable
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool ...$callbacks
             */
            static function (callable ...$callbacks): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($callbacks): Generator {
                        $defaultCallback =
                            /**
                             * @param mixed $value
                             * @param mixed $key
                             * @psalm-param T $value
                             * @psalm-param TKey $key
                             * @psalm-param Iterator<TKey, T> $iterator
                             */
                            static function ($value, $key, Iterator $iterator): bool {
                                return (bool) $value;
                            };

                        $callbacks = [] === $callbacks ?
                            [$defaultCallback] :
                            $callbacks;

                        return yield from array_reduce(
                            $callbacks,
                            static function (Iterator $carry, callable $callback): CallbackFilterIterator {
                                return new CallbackFilterIterator($carry, $callback);
                            },
                            $iterator
                        );
                    };
            };
    }
}
