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
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Associate extends AbstractOperation
{
    /**
     * @psalm-return Closure((callable(TKey, T):TKey)...): Closure((callable(TKey, T):T)...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(TKey, T):TKey ...$callbackForKeys
             *
             * @psalm-return Closure((callable(TKey, T):T)...): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (callable ...$callbackForKeys): Closure {
                return
                    /**
                     * @psalm-param callable(TKey, T):(T) ...$callbackForValues
                     *
                     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
                     */
                    static function (callable ...$callbackForValues) use ($callbackForKeys): Closure {
                        return
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<TKey, T>
                             */
                            static function (Iterator $iterator) use ($callbackForKeys, $callbackForValues): Generator {
                                $callbackForKeysFactory =
                                    /**
                                     * @param mixed $key
                                     * @psalm-param TKey $key
                                     *
                                     * @psalm-return Closure(T): Closure(TKey, callable(TKey, T): TKey): TKey
                                     */
                                    static function ($key): Closure {
                                        return
                                            /**
                                             * @param mixed $value
                                             * @psalm-param T $value
                                             *
                                             * @psalm-return Closure(TKey, callable(TKey, T): TKey): TKey
                                             */
                                            static function ($value) use ($key): Closure {
                                                return
                                                    /**
                                                     * @param mixed $carry
                                                     * @psalm-param TKey $carry
                                                     * @psalm-param callable(TKey, T): TKey $callback
                                                     *
                                                     * @psalm-return TKey
                                                     */
                                                    static function ($carry, callable $callback) use ($key, $value) {
                                                        return $callback($carry, $value);
                                                    };
                                            };
                                    };

                                $callbackForValuesFactory =
                                    /**
                                     * @param mixed $key
                                     * @psalm-param TKey $key
                                     *
                                     * @psalm-return Closure(T): Closure(T, callable(TKey, T): T): T
                                     */
                                    static function ($key): Closure {
                                        return
                                            /**
                                             * @param mixed $value
                                             * @psalm-param T $value
                                             *
                                             * @psalm-return Closure(T, callable(TKey, T): T) :T
                                             */
                                            static function ($value) use ($key): Closure {
                                                return
                                                    /**
                                                     * @param mixed $carry
                                                     * @psalm-param T $carry
                                                     * @psalm-param callable(TKey, T): T $callback
                                                     * @psalm-return T
                                                     */
                                                    static function ($carry, callable $callback) use ($key, $value) {
                                                        return $callback($key, $carry);
                                                    };
                                            };
                                    };

                                foreach ($iterator as $key => $value) {
                                    yield array_reduce($callbackForKeys, $callbackForKeysFactory($key)($value), $key) => array_reduce($callbackForValues, $callbackForValuesFactory($key)($value), $value);
                                }
                            };
                    };
            };
    }
}
