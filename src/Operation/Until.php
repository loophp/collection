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
final class Until extends AbstractOperation
{
    /**
     * @psalm-return Closure((callable(T, TKey):bool)...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey):bool ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (callable ...$callbacks): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($callbacks): Generator {
                        $reducerCallback =
                            /**
                             * @psalm-param TKey $key
                             *
                             * @psalm-return Closure(T): Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                             *
                             * @param mixed $key
                             */
                            static function ($key): Closure {
                                return
                                    /**
                                     * @psalm-param T $current
                                     *
                                     * @psalm-return Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                                     *
                                     * @param mixed $current
                                     */
                                    static function ($current) use ($key): Closure {
                                        return
                                            /**
                                             * @psalm-param Iterator<TKey, T> $iterator
                                             *
                                             * @psalm-return Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                                             */
                                            static function (Iterator $iterator) use ($key, $current): Closure {
                                                return
                                                    /**
                                                     * @psalm-param bool $carry
                                                     * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool $callable
                                                     */
                                                    static function (bool $carry, callable $callable) use ($key, $current, $iterator): bool {
                                                        return ($callable($current, $key, $iterator)) ?
                                                            $carry :
                                                            false;
                                                    };
                                            };
                                    };
                            };

                        foreach ($iterator as $key => $current) {
                            yield $key => $current;

                            $result = array_reduce(
                                $callbacks,
                                $reducerCallback($key)($current)($iterator),
                                true
                            );

                            if (false !== $result) {
                                break;
                            }
                        }
                    };
            };
    }
}
