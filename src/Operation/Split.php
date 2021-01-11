<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation\Splitable;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Split extends AbstractOperation
{
    /**
     * @psalm-return Closure(int): Closure((callable(T, TKey): bool)...): Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure((callable(T, TKey): bool)...): Closure(Iterator<TKey, T>): Generator<int, list<T>>
             */
            static fn (int $type = Splitable::BEFORE): Closure =>
                /**
                 * @psalm-param callable(T, TKey): bool ...$callbacks
                 *
                 * @psalm-return Closure(Iterator<TKey, T>): Generator<int, list<T>>
                 */
                static fn (callable ...$callbacks): Closure =>
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int, list<T>>
                     */
                    static function (Iterator $iterator) use ($type, $callbacks): Generator {
                        $carry = [];

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
                                        static fn (bool $carry, callable $callable): bool => $carry || $callable($current, $key, $iterator);

                        foreach ($iterator as $key => $value) {
                            $callbackReturn = array_reduce(
                                $callbacks,
                                $reducerCallback($key)($value)($iterator),
                                false
                            );

                            if (Splitable::AFTER === $type) {
                                $carry[] = $value;
                            }

                            if (Splitable::REMOVE === $type && true === $callbackReturn) {
                                yield $carry;

                                $carry = [];

                                continue;
                            }

                            if (true === $callbackReturn && [] !== $carry) {
                                yield $carry;

                                $carry = [];
                            }

                            if (Splitable::AFTER !== $type) {
                                $carry[] = $value;
                            }
                        }

                        if ([] !== $carry) {
                            yield $carry;
                        }
                    };
    }
}
