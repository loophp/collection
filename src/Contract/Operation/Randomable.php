<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Randomable
{
    /**
     * Returns a random item from the collection.
     *
     * An optional integer can be passed to random to specify how many items you would like to randomly retrieve.
     * An optional seed can be passed as well.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#random
     *
     * @return Collection<TKey, T>
     */
    public function random(int $size = 1, ?int $seed = null): Collection;
}
