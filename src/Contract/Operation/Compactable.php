<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Compactable
{
    /**
     * Remove given values from the collection; if no values are provided, it removes *nullsy* values.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#compact
     *
     * @param T ...$values
     *
     * @return Collection<TKey, T>
     */
    public function compact(mixed ...$values): Collection;
}
