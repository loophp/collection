<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\UnpackIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Unpack extends AbstractOperation
{
    /**
     * @return Closure(iterable<mixed, mixed>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
           /**
            * @param iterable<array{0: TKey, 1: T}> $iterable
            */
           static fn (iterable $iterable): Generator => yield from new UnpackIterableAggregate($iterable);
    }
}
