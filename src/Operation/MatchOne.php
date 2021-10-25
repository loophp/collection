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
     * @return Closure(callable(T=, TKey=, Iterator<TKey, T>=): bool ...): Closure(callable(T=, TKey=, Iterator<TKey, T>=): bool ...): Closure(Iterator<TKey, T>): Generator<TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=, Iterator<TKey, T>=): bool ...$matchers
             *
             * @return Closure(callable(T=, TKey=, Iterator<TKey, T>=): bool ...): Closure(Iterator<TKey, T>): Generator<TKey, bool>
             */
            static function (callable ...$matchers): Closure {
                return
                    /**
                     * @param callable(T=, TKey=, Iterator<TKey, T>=): bool ...$callbacks
                     *
                     * @return Closure(Iterator<TKey, T>): Generator<TKey, bool>
                     */
                    static function (callable ...$callbacks) use ($matchers): Closure {
                        /** @var Closure(Iterator<TKey, T>): Generator<TKey, bool> $pipe */
                        $pipe = Pipe::of()(
                            Map::of()(
                                /**
                                 * @param T $value
                                 * @param TKey $key
                                 * @param Iterator<TKey, T> $iterator
                                 */
                                static fn ($value, $key, Iterator $iterator): bool => CallbacksArrayReducer::or()($callbacks, $value, $key, $iterator) === CallbacksArrayReducer::or()($matchers, $value, $key, $iterator)
                            ),
                            DropWhile::of()(static fn (bool $value): bool => false === $value),
                            Append::of()(false),
                            Head::of()
                        );

                        // Point free style.
                        return $pipe;
                    };
            };
    }
}
