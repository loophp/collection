<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

use const INF;

interface Rangeable
{
    /**
     * Create a new Collection with a range of number.
     *
     * @psalm-template TKey
     * @psalm-template TKey of array-key
     * @psalm-template T
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): Collection;
}
