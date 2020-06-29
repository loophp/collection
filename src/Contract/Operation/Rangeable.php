<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

use const INF;

interface Rangeable
{
    /**
     * Create a new Collection with a range of number.
     *
     * @param float $start
     * @param float $end
     * @param float $step
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): Base;
}
