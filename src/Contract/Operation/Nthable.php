<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Nthable
{
    /**
     * Get every n-th element of a collection.
     *
     * @param int $step
     * @param int $offset
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function nth(int $step, int $offset = 0): Base;
}
