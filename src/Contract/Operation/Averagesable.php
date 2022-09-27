<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Averagesable
{
    /**
     * Calculate the average of a collection of numbers.
     *
     * The average constitute the result obtained by adding together several
     * amounts and then dividing this total by the number of amounts.
     *
     * Based on `scanLeft1`, this operation will return the average at each
     * iteration.
     * Therefore, if you're looking for one single result, you must get the last
     * item using `last` operation.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#averages
     *
     * @return Collection<int, float>
     */
    public function averages(): Collection;
}
