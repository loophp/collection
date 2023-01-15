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
final class Find extends AbstractOperation
{
    /**
     * @template V
     *
     * @return Closure(V): Closure(callable(T, TKey, iterable<TKey, T>): bool ...): Closure(iterable<TKey, T>): Generator<TKey, T|V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param V $default
             *
             * @return Closure(callable(T, TKey, iterable<TKey, T>): bool ...): Closure(iterable<TKey, T>): Generator<TKey, T|V>
             */
            static fn (mixed $default): Closure =>
                /**
                 * @param callable(T, TKey, iterable<TKey, T>): bool ...$callbacks
                 *
                 * @return Closure(iterable<TKey, T>): Generator<TKey, T|V>
                 */
                static function (callable ...$callbacks) use ($default): Closure {
                    /** @var Closure(iterable<TKey, T>): Generator<TKey, T|V> $pipe */
                    $pipe = (new Pipe())()(
                        (new Filter())()(...$callbacks),
                        (new Current())()(0)($default)
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}
