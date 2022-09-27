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
final class Keys extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, TKey>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, T>): Generator<int, TKey> $pipe */
        $pipe = (new Pipe())()(
            (new Flip())(),
            (new Normalize())()
        );

        // Point free style.
        return $pipe;
    }
}
