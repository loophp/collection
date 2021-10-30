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

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class GroupBy extends AbstractOperation
{
    /**
     * @pure
     *
     * @template NewTKey of array-key
     *
     * @return Closure(callable(T=, TKey=): NewTKey):Closure(Iterator<TKey, T>): Generator<NewTKey, non-empty-list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=): NewTKey $callable
             *
             * @return Closure(Iterator<TKey, T>): Generator<NewTKey, non-empty-list<T>>
             */
            static function (callable $callable): Closure {
                $reducerFactory =
                    /**
                     * @param callable(T=, TKey=): NewTKey $callback
                     *
                     * @return Closure(array<NewTKey, non-empty-list<T>>, T, TKey): array<NewTKey, non-empty-list<T>>
                     */
                    static fn (callable $callback): Closure =>
                        /**
                         * @param array<NewTKey, non-empty-list<T>> $collect
                         * @param T $value
                         * @param TKey $key
                         *
                         * @return non-empty-array<NewTKey, non-empty-list<T>>
                         */
                        static function (array $collect, $value, $key) use ($callback): array {
                            $collect[$callback($value, $key)][] = $value;

                            return $collect;
                        };

                /** @var Closure(Iterator<TKey, T>): Generator<NewTKey, non-empty-list<T>> $pipe */
                $pipe = Pipe::of()(
                    Reduce::of()($reducerFactory($callable))([]),
                    Flatten::of()(1)
                );

                // Point free style.
                return $pipe;
            };
    }
}
