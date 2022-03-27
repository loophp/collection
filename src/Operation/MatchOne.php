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
                        $callback = CallbacksArrayReducer::or()($callbacks);
                        $matcher = CallbacksArrayReducer::or()($matchers);

                        /** @var Closure(iterable<TKey, T>): Generator<TKey, bool> $pipe */
                        $pipe = (new Pipe())()(
                            (new Every())()(
                                /**
                                 * @param T $value
                                 * @param TKey $key
                                 */
                                static fn (int $index, $value, $key, iterable $iterable): bool => $callback($value, $key, $iterable) !== $matcher($value, $key, $iterable)
                            ),
                            (new Map())()(
                                static fn (bool $i): bool => !$i
                            )
                        );

                        // Point free style.
                        return $pipe;
                    };
            };
    }
}
