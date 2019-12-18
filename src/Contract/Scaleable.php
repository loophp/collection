<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Scaleable.
 */
interface Scaleable
{
    /**
     * Scale/normalize values.
     *
     * @param float $lowerBound
     * @param float $upperBound
     * @param float|null $wantedLowerBound
     * @param float|null $wantedUpperBound
     * @param float|null $base
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function scale(
        float $lowerBound,
        float $upperBound,
        ?float $wantedLowerBound = null,
        ?float $wantedUpperBound = null,
        ?float $base = null
    ): Base;
}
