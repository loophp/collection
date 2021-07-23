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
interface Intersectable
{
    /**
     * Removes any values from the original collection that are not present in the given values set.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#intersect
     *
     * @param mixed ...$values
     *
     * @return Collection<TKey, T>
     */
    public function intersect(...$values): Collection;
}
