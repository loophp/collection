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
final class Has extends AbstractOperation
{
    /**
     * @return Closure(callable(T, TKey, iterable<TKey, T>): T ...): Closure(iterable<TKey, T>): Generator<TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T, TKey, iterable<TKey, T>): T ...$callbacks
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, bool>
             */
            static fn (callable ...$callbacks): Closure => (new MatchOne())()(static fn (): bool => true)(
                ...array_map(
                    static fn (callable $callback): callable =>
                            /**
                             * @param T $value
                             * @param TKey $key
                             * @param iterable<TKey, T> $iterable
                             */
                            static fn ($value, $key, iterable $iterable): bool => $callback($value, $key, $iterable) === $value,
                    $callbacks
                )
            );
    }
}
