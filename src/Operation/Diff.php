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
final class Diff extends AbstractOperation
{
    /**
     * @return Closure(T...): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T ...$values
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (...$values): Closure => (new Filter())()(
                /**
                 * @param T $value
                 */
                static fn ($value): bool => !in_array($value, $values, true)
            );
    }
}
