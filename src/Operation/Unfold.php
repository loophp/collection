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
final class Unfold extends AbstractOperation
{
    /**
     * @return Closure(array<int, T>): Closure(callable(T...): list<T>): Closure(): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, T> $parameters
             *
             * @return Closure(callable(T...): list<T>): Closure(): Generator<int, list<T>>
             */
            static fn ($parameters): Closure =>
                /**
                 * @param callable(T...): list<T> $callback
                 *
                 * @return Closure(): Generator<int, list<T>>
                 */
                static fn (callable $callback): Closure =>
                    /**
                     * @return Generator<int, list<T>>
                     */
                    static function () use ($parameters, $callback): Generator {
                        while (true) {
                            $parameters = $callback(...$parameters);

                            yield $parameters;
                        }
                    };
    }
}
