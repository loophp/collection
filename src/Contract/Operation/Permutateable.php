<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Permutateable
{
    /**
     * Find all the permutations of a collection.
     */
    public function permutate(): Collection;
}
