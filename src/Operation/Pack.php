<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\PackIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Pack extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, array{0: TKey, 1: T}>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Generator<int, array{0: TKey, 1: T}>
             */
            static fn (iterable $iterable): Generator => yield from new PackIterableAggregate($iterable);
    }
}
