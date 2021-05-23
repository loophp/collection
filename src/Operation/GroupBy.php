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
 * @template TKey of array-key
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class GroupBy extends AbstractOperation
{
    /**
     * @return Closure((null | callable(TKey, T ): (TKey | null))):Closure (Iterator<TKey, T>): Generator<int, T|list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param null|callable(TKey, T):(TKey|null) $callable
             *
             * @return Closure(Iterator<TKey, T>): Generator<int, T|list<T>>
             */
            static function (?callable $callable = null): Closure {
                /** @psalm-var callable(T, TKey): (TKey|null) $callable */
                $callable = $callable ??
                    /**
                     * @param mixed $value
                     * @psalm-param T $value
                     *
                     * @param mixed $key
                     * @psalm-param TKey $key
                     *
                     * @return TKey
                     */
                    static fn ($value, $key) => $key;

                $reducerFactory =
                    /**
                     * @psalm-param callable(T, TKey): (TKey|null) $callback
                     *
                     * @return Closure(array<TKey, T|list<T>>, T, TKey): array<TKey, T|list<T>>
                     */
                    static fn (callable $callback): Closure =>
                        /**
                         * @psalm-param array<TKey, list<T>> $collect
                         *
                         * @param mixed $value
                         * @psalm-param T $value
                         *
                         * @param mixed $key
                         * @psalm-param TKey $key
                         *
                         * @return non-empty-array<TKey, T|list<T>>
                         */
                        static function (array $collect, $value, $key) use ($callback): array {
                            if (null !== $groupKey = $callback($value, $key)) {
                                $collect[$groupKey][] = $value;
                            } else {
                                $collect[$key] = $value;
                            }

                            return $collect;
                        };

                /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, list<T>> $pipe */
                $pipe = Pipe::of()(
                    FoldLeft::of()($reducerFactory($callable))([]),
                    Unwrap::of()
                );

                // Point free style.
                return $pipe;
            };
    }
}
