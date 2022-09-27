<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Permutateable
{
    /**
     * Find all the permutations of a collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#permutate
     *
     * @return Collection<TKey, T>
     */
    public function permutate(): Collection;
}
