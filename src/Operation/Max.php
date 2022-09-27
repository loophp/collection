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
final class Max extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        $comparator =
            /**
             * @param T $carry
             * @param T $value
             *
             * @return T
             */
            static fn ($carry, $value) => max($value, $carry);

        return (new Compare())()($comparator);
    }
}
