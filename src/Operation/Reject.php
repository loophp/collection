<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Utils\CallbacksArrayReducer;
use loophp\iterators\FilterIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Reject extends AbstractOperation
{
    /**
     * @return Closure(callable(T, TKey, iterable<TKey, T>): bool ...): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T, TKey, iterable<TKey, T>): bool ...$callbacks
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<TKey, T>
                 */
                static function (iterable $iterable) use ($callbacks): Generator {
                    $defaultCallback =
                        /**
                         * @param T $value
                         *
                         * @return T
                         */
                        static fn (mixed $value): mixed => $value;

                    $callback = [] === $callbacks ?
                        $defaultCallback :
                        CallbacksArrayReducer::or()($callbacks);

                    $callback =
                        /**
                         * @param T $current
                         * @param TKey $key
                         * @param iterable<TKey, T> $iterable
                         */
                        static fn (mixed $current, mixed $key, mixed $iterable): bool => !(bool)$callback($current, $key, $iterable);

                    yield from new FilterIterableAggregate($iterable, $callback);
                };
    }
}
