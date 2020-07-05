<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Productable
{
    /**
     * Get the the cartesian product of items of a collection.
     *
     * @param iterable<mixed> ...$iterables
     */
    public function product(iterable ...$iterables): Collection;
}
