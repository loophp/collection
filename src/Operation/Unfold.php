<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

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
     * @psalm-return Closure(T...): Closure(callable(mixed|T...): (mixed|array<TKey, T>)): Closure(): Generator<int, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param mixed $parameters
             * @psalm-param T ...$parameters
             *
             * @psalm-return Closure(callable(mixed|T...): (array<TKey, T>)): Closure(): Generator<int, T>
             */
            static fn (...$parameters): Closure =>
                /**
                 * @psalm-param callable(mixed|T...): (mixed|array<TKey, T>) $callback
                 *
                 * @psalm-return Closure(): Generator<int, T>
                 */
                static fn (callable $callback): Closure =>
                    /**
                     * @psalm-return Generator<int, T>
                     */
                    static function () use ($parameters, $callback): Generator {
                        while (true) {
                            yield $parameters = $callback(...array_values((array) $parameters));
                        }
                    };
    }
}
