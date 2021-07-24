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
interface Diffable
{
    /**
     * Compares the collection against another collection, iterable, or set of multiple values.
     * This method will return the values in the original collection that are not present in the given argument set.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#diff
     *
     * @param T ...$values
     *
     * @return Collection<TKey, T>
     */
    public function diff(...$values): Collection;
}
