<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Productable.
 */
interface Productable
{
    /**
     * Get the the cartesian product of items of a collection.
     *
     * @param iterable<mixed> ...$iterables
     *
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function product(iterable ...$iterables): Base;
}
