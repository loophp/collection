<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Wrapable
{
    /**
     * Wrap every element into an array.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#wrap
     *
     * @return Collection<int, array<array-key, T>>
     */
    public function wrap(): Collection;
}
