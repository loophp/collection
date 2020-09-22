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
final class Unwrap extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, array<TKey, T>>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var Closure(Iterator<TKey, array<TKey, T>>): Generator<TKey, T> $compose */
        $compose = Compose::of()(
            Flatten::of()(1)
        );

        // Point free style.
        return $compose;
    }
}
