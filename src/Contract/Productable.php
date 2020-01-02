<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Productable.
 */
interface Productable
{
    /**
     * Compute the cartesian product.
     *
     * @param iterable ...$iterables
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function product(iterable ...$iterables): Base;
}
