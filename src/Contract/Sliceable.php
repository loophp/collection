<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Sliceable.
 */
interface Sliceable
{
    /**
     * Get a slice of items.
     *
     * @param int $offset
     * @param null|int $length
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function slice(int $offset, int $length = null): Collection;
}
