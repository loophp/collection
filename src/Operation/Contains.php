<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

use function in_array;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Contains extends AbstractOperation
{
    /**
     * @return Closure(array<T>): Closure(iterable<TKey, T>): Generator<TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param array<T> $values
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, bool>
             */
            static fn (array $values): Closure => (new MatchOne())()(static fn (): bool => true)(
                /**
                 * @param T $value
                 */
                static fn (mixed $value): bool => in_array($value, $values, true)
            );
    }
}
