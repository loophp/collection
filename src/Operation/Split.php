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
final class Split extends AbstractOperation
{
    /**
     * @return Closure((callable(T, TKey): bool)...): Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey): bool ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, list<T>>
             */
            static function (callable ...$callbacks): Closure {
                return
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 * @psalm-param list<callable(T, TKey):(bool)> $callbacks
                 *
                 * @psalm-return Generator<int, list<T>>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    $carry = [];

                    $reducer =
                        /**
                         * @psalm-param TKey $key
                         *
                         * @psalm-return Closure(T): Closure(bool, callable(T, TKey): bool): bool
                         *
                         * @param mixed $key
                         */
                        static function ($key): Closure {
                            return
                                /**
                                 * @psalm-param T $value
                                 *
                                 * @psalm-return Closure(bool, callable(T, TKey): bool): bool
                                 *
                                 * @param mixed $value
                                 */
                                static function ($value) use ($key): Closure {
                                    return
                                        /**
                                         * @psalm-param callable(T, TKey): bool $callback
                                         */
                                        static function (bool $carry, callable $callback) use ($key, $value): bool {
                                            return $callback($value, $key) !== $carry;
                                        };
                                };
                        };

                    foreach ($iterator as $key => $value) {
                        $callbackReturn = array_reduce($callbacks, $reducer($key)($value), false);

                        if (true === $callbackReturn && [] !== $carry) {
                            yield $carry;

                            $carry = [];
                        }

                        $carry[] = $value;
                    }

                    if ([] !== $carry) {
                        yield $carry;
                    }
                };
            };
    }
}
