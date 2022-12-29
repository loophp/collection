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
final class Last extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $pipe */
        $pipe = (new Pipe)()(
            (new Reverse)(),
            // We could use `Head` here, but I use `Limit` for minor perf boost.
            (new Limit())()(1)(0)
        );

        // Point free style.
        return $pipe;
    }
}
