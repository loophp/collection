<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\IterableIterator;

/**
 * @template T
 * @template TKey
 * @psalm-template TKey of array-key
 * @implements Transformation<TKey, T, int>
 */
final class Count implements Transformation
{
    /**
     * @param iterable<TKey, T> $collection
     */
    public function __invoke(iterable $collection): int
    {
        return iterator_count(new IterableIterator($collection));
    }
}
