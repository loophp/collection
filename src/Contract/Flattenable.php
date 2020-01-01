<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use const PHP_INT_MAX;

/**
 * Interface Flattenable.
 */
interface Flattenable
{
    /**
     * Get a flattened list of the items in the collection.
     *
     * @param int $depth
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function flatten(int $depth = PHP_INT_MAX): Base;
}
