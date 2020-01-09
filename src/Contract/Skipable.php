<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Skipable.
 */
interface Skipable
{
    /**
     * Skip the n items of a collection.
     *
     * @param int ...$counts
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function skip(int ...$counts): Base;
}
