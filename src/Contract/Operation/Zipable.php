<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @template UKey
 * @psalm-template UKey of array-key
 */
interface Zipable
{
    /**
     * Zip a collection together with one or more iterables.
     *
     * @param iterable<UKey, U> ...$iterables
     *
     * @return Collection<int, array<T, U>|false>
     */
    public function zip(iterable ...$iterables): Collection;
}
