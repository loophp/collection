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
final class Unfold extends AbstractOperation
{
    /**
     * @psalm-return Closure(T...): Closure(callable(T...): (array<TKey, T>)): Closure(null|Iterator<TKey, T>): Generator<int, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param mixed $parameters
             * @psalm-param T ...$parameters
             *
             * @psalm-return Closure(callable(T...): (array<TKey, T>)): Closure(null|Iterator<TKey, T>): Generator<int, T>
             */
            static fn (...$parameters): Closure =>
                /**
                 * @psalm-param callable(T...): (array<TKey, T>) $callback
                 *
                 * @psalm-return Closure(null|Iterator<TKey, T>): Generator<int, T>
                 */
                static fn (callable $callback): Closure =>
                    /**
                     * @psalm-param null|Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int, T>
                     */
                    static function (?Iterator $iterator = null) use ($parameters, $callback): Generator {
                        while (true) {
                            yield $parameters = $callback(...array_values((array) $parameters));
                        }
                    };
    }
}
