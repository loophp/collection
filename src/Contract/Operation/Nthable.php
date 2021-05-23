<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey of array-key
 * @template T
 */
interface Nthable
{
    /**
     * Get every n-th element of a collection.
     *
     * @return \loophp\collection\Collection<TKey, T>
     */
    public function nth(int $step, int $offset = 0): Collection;
}
