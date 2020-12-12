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
final class Keys extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, TKey>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, TKey> $pipe */
        $pipe = Pipe::of()(
            Flip::of(),
            Normalize::of()
        );

        // Point free style.
        return $pipe;
    }
}
