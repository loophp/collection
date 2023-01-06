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
 */
final class GroupBy extends AbstractOperation
{
    /**
     * @return Closure(callable(T, TKey): array-key): Closure(iterable<TKey, T>): Generator<array-key, non-empty-list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T, TKey): array-key $callback
             *
             * @return Closure(iterable<TKey, T>): Generator<array-key, non-empty-list<T>>
             */
            static function (callable $callback): Closure {
                $reducerFactory =
                    /**
                     * @param array<array-key, non-empty-list<T>> $collect
                     * @param T $value
                     * @param TKey $key
                     *
                     * @return non-empty-array<array-key, non-empty-list<T>>
                     */
                    static function (array $collect, mixed $value, mixed $key) use ($callback): array {
                        $collect[$callback($value, $key)][] = $value;

                        return $collect;
                    };

                /** @var Closure(iterable<TKey, T>): Generator<array-key, non-empty-list<T>> $pipe */
                $pipe = (new Pipe())()(
                    (new Reduce())()($reducerFactory)([]),
                    (new Flatten())()(1)
                );

                // Point free style.
                return $pipe;
            };
    }
}
