<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface RSampleable
{
    /**
     * Take a random sample of elements of items from a collection.
     * Accepts a probability parameter which will influence the number of items sampled;
     * higher probabilities increase the chance of sampling close to the entire collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#rsample
     *
     * @return Collection<TKey, T>
     */
    public function rsample(float $probability): Collection;
}
