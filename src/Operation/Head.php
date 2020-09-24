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
 */
final class Head extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $first */
        $first = First::of();

        // Point free style.
        return $first;
    }
}
