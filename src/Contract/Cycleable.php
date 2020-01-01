<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Cycleable.
 */
interface Cycleable
{
    /**
     * @param int $length
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function cycle(int $length = 0): Base;
}
