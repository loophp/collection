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
final class Map extends AbstractOperation
{
    /**
     * @psalm-return Closure((callable(T, TKey): T)...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey): T ...$callbacks
             */
            static function (callable ...$callbacks): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($callbacks): Generator {
                        $callbackFactory =
                            /**
                             * @psalm-param TKey $key
                             *
                             * @psalm-return Closure(T): Closure(T, callable(T, TKey): T): T
                             *
                             * @param mixed $key
                             */
                            static function ($key): Closure {
                                return
                                    /**
                                     * @psalm-param T $value
                                     *
                                     * @psalm-return Closure(T, callable(T, TKey): T): T
                                     *
                                     * @param mixed $value
                                     */
                                    static function ($value) use ($key): Closure {
                                        return
                                            /**
                                             * @psalm-param T $carry
                                             * @psalm-param callable(T, TKey): T $callback
                                             *
                                             * @psalm-return T
                                             *
                                             * @param mixed $carry
                                             */
                                            static function ($carry, callable $callback) use ($key, $value) {
                                                return $callback($value, $key);
                                            };
                                    };
                            };

                        // phpcs:disable
                        foreach ($iterator as $key => $value) {
                            yield $key => array_reduce($callbacks, $callbackFactory($key)($value));
                        }
                        // phpcs:enable
                    };
            };
    }
}
