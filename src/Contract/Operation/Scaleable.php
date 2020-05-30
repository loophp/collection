<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

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
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function scale(
        float $lowerBound,
        float $upperBound,
        ?float $wantedLowerBound = null,
        ?float $wantedUpperBound = null,
        ?float $base = null
    ): Base;
}
