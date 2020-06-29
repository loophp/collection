<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Skipable
{
    /**
     * Skip the n items of a collection.
     *
     * @param int ...$counts
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function skip(int ...$counts): Base;
}
