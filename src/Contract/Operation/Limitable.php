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
interface Limitable
{
    /**
     * Limit the number of values in the collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#limit
     *
     * @return Collection<TKey, T>
     */
    public function limit(int $count = -1, int $offset = 0): Collection;
}
