<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Skipable.
 */
interface Skipable
{
    /**
     * Skip the first {$count} items.
     *
     * @param int ...$counts
     *
     * @return \drupol\collection\Contract\Collection<mixed>
     */
    public function skip(int ...$counts): Base;
}
