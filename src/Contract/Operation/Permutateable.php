<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 */
interface Permutateable
{
    /**
     * Find all the permutations of a collection.
     *
     * @return Collection<int, list<T>>
     */
    public function permutate(): Collection;
}
