<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Scaleable
{
    /**
     * Scale/normalize values.Scale/normalize values.
     * Values will be scaled between  `0` and `1` by default, if no desired bounds are provided.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#scale
     *
     * @return Collection<TKey, float|int>
     */
    public function scale(
        float $lowerBound,
        float $upperBound,
        float $wantedLowerBound = 0.0,
        float $wantedUpperBound = 1.0,
        float $base = 0.0
    ): Collection;
}
