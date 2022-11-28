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
final class Unwindow extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, list<T>>): Generator<TKey, T|null>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, list<T>>): Generator<TKey, T|null> $pipe */
        $pipe = (new Pipe())()(
            (new Map())()(
                /**
                 * @param list<T> $iterable
                 *
                 * @return Generator<TKey, T>
                 */
                static fn (iterable $iterable): Generator => (new Last())()($iterable)
            ),
            (new Map())()(
                /**
                 * @param Generator<TKey, T> $iterable
                 *
                 * @return T|null
                 */
                static fn (Generator $iterable): mixed => $iterable->current()
            ),
        );

        // Point free style.
        return $pipe;
    }
}
