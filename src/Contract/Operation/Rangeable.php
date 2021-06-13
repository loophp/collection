<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

use const INF;

interface Rangeable
{
    /**
     * Create a new Collection with a range of number.
     *
     * @template TKey
     * @template TKey
     * @template T
     *
     * @return Collection<int, float>
     */
    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): Collection;
}
