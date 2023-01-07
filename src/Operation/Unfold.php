<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 */
final class Unfold extends AbstractOperation
{
    /**
     * @template TKey
     * @template T
     *
     * @return Closure(iterable<TKey, T>): Closure(callable(T...): iterable<array-key, T>): Closure(): Generator<int, iterable<array-key, T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<array-key, T> $parameters
             *
             * @return Closure(callable(T...): iterable<array-key, T>): Closure(): Generator<int, iterable<array-key, T>>
             */
            static fn (iterable $parameters): Closure =>
                /**
                 * @param callable(T...): iterable<array-key, T> $callback
                 *
                 * @return Closure(): Generator<int, iterable<array-key, T>>
                 */
                static fn (callable $callback): Closure =>
                    /**
                     * @return Generator<int, iterable<array-key, T>>
                     */
                    static function () use ($parameters, $callback): Generator {
                        while (true) {
                            $parameters = $callback(...$parameters);

                            yield $parameters;
                        }
                    };
    }
}
