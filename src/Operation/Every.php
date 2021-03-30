<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use function call_user_func_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Every extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>): bool ...): Closure(Iterator<TKey, T>): Generator<int|TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool ...$callbacks
             */
            static function (callable ...$callbacks): Closure {
                $reducerCallback =
                    /**
                     * @param mixed $key
                     * @psalm-param TKey $key
                     *
                     * @psalm-return Closure(T): Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                     */
                    static fn ($key): Closure =>
                        /**
                         * @param mixed $current
                         * @psalm-param T $current
                         *
                         * @psalm-return Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                         */
                        static fn ($current): Closure =>
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                             */
                            static fn (Iterator $iterator): Closure =>
                                /**
                                 * @psalm-param bool $carry
                                 * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool $callable
                                 */
                                static fn (bool $carry, callable $callable): bool => $carry || call_user_func_array($callable, [$current, $key, $iterator]);

                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int|TKey, bool>
                     */
                    static function (Iterator $iterator) use ($callbacks, $reducerCallback): Generator {
                        // We could use FoldLeft but there is no need to go through all the items,
                        // we just need to return false as soon as the callbacks returns false.
                        foreach ($iterator as $key => $value) {
                            $result = array_reduce(
                                $callbacks,
                                $reducerCallback($key)($value)($iterator),
                                false
                            );

                            if (false === $result) {
                                return yield $key => false;
                            }
                        }

                        return yield true;
                    };
            };
    }
}
