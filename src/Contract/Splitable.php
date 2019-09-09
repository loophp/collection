<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Splitable.
 */
interface Splitable
{
    /**
     * Get a slice of items.
     *
     * @param callable ...$callbacks
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function split(callable ...$callbacks): Base;
}
