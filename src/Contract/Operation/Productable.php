<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Productable
{
    /**
     * Get the the cartesian product of items of a collection.
     *
     * @param iterable<TKey, T> ...$iterables
     *
     * @return Collection<int, array<int, T>>
     */
    public function product(iterable ...$iterables): Collection;
}
