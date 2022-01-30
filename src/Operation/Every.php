<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Utils\CallbacksArrayReducer;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Every extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable(T, TKey, iterable<TKey, T>...): bool): Closure(callable(T, TKey, iterable<TKey, T>...): bool): Closure(iterable<TKey, T>): Generator<TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$matchers
             *
             * @return Closure(...callable(T=, TKey=, iterable<TKey, T>=): bool): Closure(iterable<TKey, T>): Generator<TKey, bool>
             */
            static function (callable ...$matchers): Closure {
                return
                    /**
                     * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
                     *
                     * @return Closure(iterable<TKey, T>): Generator<TKey, bool>
                     */
                    static function (callable ...$callbacks) use ($matchers): Closure {
                        $callbackReducer =
                            /**
                             * @param list<callable(T=, TKey=, iterable<TKey, T>=): bool> $callbacks
                             *
                             * @return Closure(T, TKey, iterable<TKey, T>): bool
                             */
                            static fn (array $callbacks): Closure =>
                                /**
                                 * @param T $current
                                 * @param TKey $key
                                 * @param iterable<TKey, T> $iterable
                                 */
                                static fn ($current, $key, iterable $iterable): bool => CallbacksArrayReducer::or()($callbacks, $current, $key, $iterable);

                        $mapCallback =
                            /**
                             * @param callable(T=, TKey=, iterable<TKey, T>=): mixed $reducer1
                             *
                             * @return Closure(callable(T=, TKey=, iterable<TKey, T>=)): Closure(T, TKey, iterable<TKey, T>): bool
                             */
                            static fn (callable $reducer1): Closure =>
                                /**
                                 * @param callable(T=, TKey=, iterable<TKey, T>=): mixed $reducer2
                                 *
                                 * @return Closure(T, TKey, iterable<TKey, T>): bool
                                 */
                                static fn (callable $reducer2): Closure =>
                                    /**
                                     * @param T $value
                                     * @param TKey $key
                                     * @param iterable<TKey, T> $iterable
                                     */
                                    static fn ($value, $key, iterable $iterable): bool => $reducer1($value, $key, $iterable) !== $reducer2($value, $key, $iterable);

                        /** @var Closure(iterable<TKey, T>): Generator<TKey, bool> $pipe */
                        $pipe = (new Pipe())()(
                            (new Map())()($mapCallback($callbackReducer($callbacks))($callbackReducer($matchers))),
                            (new DropWhile())()(static fn (bool $value): bool => $value),
                            (new Append())()(true),
                            (new Head())(),
                        );

                        // Point free style.
                        return $pipe;
                    };
            };
    }
}
