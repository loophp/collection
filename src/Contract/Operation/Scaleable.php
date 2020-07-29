<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Scaleable
{
    /**
     * Scale/normalize values.
     *
     * @param ?float $wantedLowerBound
     * @param ?float $wantedUpperBound
     * @param ?float $base
     *
     * @return \loophp\collection\Base<TKey, T>|\loophp\collection\Contract\Collection<TKey, T>
     */
    public function scale(
        float $lowerBound,
        float $upperBound,
        ?float $wantedLowerBound = null,
        ?float $wantedUpperBound = null,
        ?float $base = null
    ): Base;
}
