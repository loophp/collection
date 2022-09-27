<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Sliceable
{
    /**
     * Get a slice of a collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#slice
     *
     * @return Collection<TKey, T>
     */
    public function slice(int $offset, int $length = -1): Collection;
}
