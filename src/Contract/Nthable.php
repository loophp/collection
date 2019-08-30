<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Nthable.
 */
interface Nthable
{
    /**
     * Create a new collection consisting of every n-th element.
     *
     * @param int $step
     * @param int $offset
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function nth(int $step, int $offset = 0): Base;
}
