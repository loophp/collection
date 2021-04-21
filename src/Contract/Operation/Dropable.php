<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Dropable
{
    /**
     * Skip the n items of a collection.
     *
     * @param int ...$counts
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function drop(int ...$counts): Collection;
}
