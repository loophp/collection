<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Productable
{
    /**
     * Get the the cartesian product of items of a collection.
     *
     * @param iterable<mixed> ...$iterables
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function product(iterable ...$iterables): Base;
}
