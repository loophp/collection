<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Intersectable
{
    /**
     * Removes any values from the original collection that are not present in the given values set.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#intersect
     *
     * @return Collection<TKey, T>
     */
    public function intersect(mixed ...$values): Collection;
}
