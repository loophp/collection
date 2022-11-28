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
final class Truthy extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return (new Every())()(
            /**
             * @param T $value
             */
            static fn (int $index, mixed $value): bool => (bool) $value
        );
    }
}
