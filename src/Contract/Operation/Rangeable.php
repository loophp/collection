<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

use const INF;

/**
 * @template TKey
 * @template T
 */
interface Rangeable
{
    /**
     * Build a collection from a range of values.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#range
     *
     * @return Collection<int, float>
     */
    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): Collection;
}
