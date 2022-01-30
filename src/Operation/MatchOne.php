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
final class MatchOne extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable(T=, TKey=, iterable<TKey, T>=): bool ...): Closure(callable(T=, TKey=, iterable<TKey, T>=): bool ...): Closure(iterable<TKey, T>): Generator<TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$matchers
             *
             * @return Closure(callable(T=, TKey=, iterable<TKey, T>=): bool ...): Closure(iterable<TKey, T>): Generator<TKey, bool>
             */
            static function (callable ...$matchers): Closure {
                return
                    /**
                     * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
                     *
                     * @return Closure(iterable<TKey, T>): Generator<TKey, bool>
                     */
                    static function (callable ...$callbacks) use ($matchers): Closure {
                        /** @var Closure(iterable<TKey, T>): Generator<TKey, bool> $pipe */
                        $pipe = (new Pipe())()(
                            (new Map())()(
                                /**
                                 * @param T $value
                                 * @param TKey $key
                                 * @param iterable<TKey, T> $iterable
                                 */
                                static fn ($value, $key, iterable $iterable): bool => CallbacksArrayReducer::or()($callbacks, $value, $key, $iterable) === CallbacksArrayReducer::or()($matchers, $value, $key, $iterable)
                            ),
                            (new DropWhile())()(static fn (bool $value): bool => !$value),
                            (new Append())()(false),
                            (new Head())()
                        );

                        // Point free style.
                        return $pipe;
                    };
            };
    }
}
