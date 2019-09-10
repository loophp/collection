<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Cycleable.
 */
interface Cycleable
{
    /**
     * @param int $count
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function cycle(int $count = 0): Base;
}
