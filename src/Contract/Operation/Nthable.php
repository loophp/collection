<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Nthable
{
    /**
     * Get every n-th element of a collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#nth
     *
     * @return Collection<TKey, T>
     */
    public function nth(int $step, int $offset = 0): Collection;
}
