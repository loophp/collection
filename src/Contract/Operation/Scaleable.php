<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
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
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function scale(
        float $lowerBound,
        float $upperBound,
        ?float $wantedLowerBound = null,
        ?float $wantedUpperBound = null,
        ?float $base = null
    ): Collection;
}
