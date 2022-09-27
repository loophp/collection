<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Cycleable
{
    /**
     * Cycle indefinitely around a collection of items.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#cycle
     *
     * @return Collection<TKey, T>
     */
    public function cycle(): Collection;
}
