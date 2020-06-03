<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

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
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function skip(int ...$counts): Base;
}
