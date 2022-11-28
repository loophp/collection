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
final class MapN extends AbstractOperation
{
    /**
     * @return Closure(callable(mixed, mixed, iterable<TKey, T>): mixed ...): Closure(iterable<TKey, T>): Generator<mixed, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(mixed, mixed, iterable<TKey, T>): mixed ...$callbacks
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<mixed, mixed>
                 */
                static function (iterable $iterable) use ($callbacks): Generator {
                    $callbackFactory =
                        /**
                         * @return Closure(mixed, callable(mixed, mixed, iterable<TKey, T>): mixed): mixed
                         */
                        static fn (mixed $key): Closure =>
                            /**
                             * @param callable(mixed, mixed, iterable<TKey, T>): mixed $callback
                             */
                            static fn (mixed $carry, callable $callback): mixed => $callback($carry, $key, $iterable);

                    foreach ($iterable as $key => $value) {
                        yield $key => array_reduce($callbacks, $callbackFactory($key), $value);
                    }
                };
    }
}
