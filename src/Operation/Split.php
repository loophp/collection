<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation\Splitable;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Split extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(int): Closure((callable(T, TKey): bool)...): Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure((callable(T, TKey): bool)...): Closure(Iterator<TKey, T>): Generator<int, list<T>>
             */
            static fn (int $type = Splitable::BEFORE): Closure =>
                /**
                 * @param callable(T, TKey): bool ...$callbacks
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<int, list<T>>
                 */
                static fn (callable ...$callbacks): Closure =>
                    /**
                     * @param Iterator<TKey, T> $iterator
                     *
                     * @return Generator<int, list<T>>
                     */
                    static function (Iterator $iterator) use ($type, $callbacks): Generator {
                        $carry = [];

                        $reducerCallback =
                            /**
                             * @param TKey $key
                             *
                             * @return Closure(T): Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                             */
                            static fn ($key): Closure =>
                                /**
                                 * @param T $current
                                 *
                                 * @return Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                                 */
                                static fn ($current): Closure =>
                                    /**
                                     * @param Iterator<TKey, T> $iterator
                                     *
                                     * @return Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                                     */
                                    static fn (Iterator $iterator): Closure =>
                                        /**
                                         * @param bool $carry
                                         * @param callable(T, TKey, Iterator<TKey, T>): bool $callable
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
