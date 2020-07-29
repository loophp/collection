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
     * @template TKey
     * @psalm-template TKey of array-key
     * @template T
     *
     * @return \loophp\collection\Base<TKey, T>|\loophp\collection\Contract\Collection<TKey, T>
     */
    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): Base;
}
