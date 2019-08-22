<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

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
     * @return \drupol\collection\Contract\BaseCollection
     */
    public function flatten(int $depth = \PHP_INT_MAX): BaseCollection;
}
