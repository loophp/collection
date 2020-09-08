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
                                             * @psalm-param bool $carry
                                             * @psalm-param  callable(T, TKey): bool $callable
                                             */
                                            static function (bool $carry, callable $callable) use ($key, $value): bool {
                                                return ($callable($value, $key)) ?
                                                    $carry :
                                                    false;
                                            };
                                    };
                            };

                        foreach ($iterator as $key => $value) {
                            yield $key => $value;

                            $result = array_reduce(
                                $callbacks,
                                $reducerCallback($key)($value),
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
