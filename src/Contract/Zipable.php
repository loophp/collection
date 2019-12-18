<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Zipable.
 */
interface Zipable
{
    /**
     * Zip the collection together with one or more arrays.
     *
     * e.g. new Collection([1, 2, 3])->zip([4, 5, 6]);
     *      => [[1, 4], [2, 5], [3, 6]]
     *
     * @param mixed ...$items
     *
     * @return \drupol\collection\Contract\Collection<mixed>
     */
    public function zip(...$items): Base;
}
