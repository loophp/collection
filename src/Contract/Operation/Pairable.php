<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Pairable
{
    /**
     * Make an associative collection from pairs of values.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#pair
     *
     * @return Collection<T, T|null>
     */
    public function pair(): Collection;
}
