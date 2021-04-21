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
     * @psalm-template TKey
     * @psalm-template TKey of array-key
     * @psalm-template T
     *
     * @psalm-return \loophp\collection\Collection<int, int|float>
     */
    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): Collection;
}
