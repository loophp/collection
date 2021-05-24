<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Timesable
{
    /**
     * Create a new instance by invoking the callback a given amount of times.
     *
     * @template TKey
     * @template TKey
     * @template T
     *
     * @param null|callable(int): (int|T) $callback
     *
     * @return \loophp\collection\Collection<int, int|T>
     */
    public static function times(int $number = 0, ?callable $callback = null): Collection;
}
