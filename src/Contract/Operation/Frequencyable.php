<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Frequencyable
{
    /**
     * Calculate the frequency of the items in the collection
     * Returns a new key-value collection with frequencies as keys.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#frequency
     *
     * @return Collection<int, T>
     */
    public function frequency(): Collection;
}
