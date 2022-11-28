<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Diffable
{
    /**
     * Compares the collection against another collection, iterable, or set of multiple values.
     * This method will return the values in the original collection that are not present in the given argument set.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#diff
     *
     * @template U
     *
     * @param U ...$values
     *
     * @return Collection<TKey, T>
     */
    public function diff(mixed ...$values): Collection;
}
