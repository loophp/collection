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
interface Columnable
{
    /**
     * Return the values from a single column in the input iterables.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#column
     *
     * @param mixed $column
     *
     * @return Collection<int, mixed>
     */
    public function column($column): Collection;
}
