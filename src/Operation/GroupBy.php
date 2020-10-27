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
 */
final class GroupBy extends AbstractOperation
{
    /**
     * @psalm-return Closure((null | callable(TKey , T ): (TKey | null))):Closure (Iterator<TKey, T>): Generator<int, T|list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param null|callable(TKey, T):(TKey|null) $callable
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, T|list<T>>
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
                     * @return mixed
                     * @psalm-return TKey
                     */
                    static fn ($value, $key) => $key;

                $reducerFactory =
                    /**
                     * @psalm-param callable(T, TKey): (TKey|null) $callback
                     *
                     * @psalm-return Closure(array<TKey, T|list<T>>, T, TKey): array<TKey, T|list<T>>
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
                         * @psalm-return non-empty-array<TKey, T|list<T>>
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
