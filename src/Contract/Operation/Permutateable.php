<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Permutateable
{
    /**
     * Find all the permutations of a collection.
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function permutate(): Base;
}
