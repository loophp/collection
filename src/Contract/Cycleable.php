<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Cycleable.
 */
interface Cycleable
{
    /**
     * @param int $length
     *
     * @return \drupol\collection\Contract\Collection<mixed>
     */
    public function cycle(int $length = 0): Base;
}
