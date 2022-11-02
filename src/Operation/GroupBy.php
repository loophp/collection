<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

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
     * @template NewTKey
     *
     * @return Closure(callable(T=, TKey=): NewTKey): Closure(iterable<TKey, T>): Generator<NewTKey, non-empty-list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=): NewTKey $callable
             *
             * @return Closure(iterable<TKey, T>): Generator<NewTKey, non-empty-list<T>>
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

                /** @var Closure(iterable<TKey, T>): Generator<NewTKey, non-empty-list<T>> $pipe */
                $pipe = (new Pipe())()(
                    (new Reduce())()($reducerFactory($callable))([]),
                    (new Flatten())()(1)
                );

                // Point free style.
                return $pipe;
            };
    }
}
