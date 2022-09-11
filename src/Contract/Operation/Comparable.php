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
interface Comparable
{
    /**
     * Fold the collection through a comparison operation, yielding the "highest" or "lowest"
     * element as defined by the comparator callback. The callback takes a pair of two elements
     * and should return the "highest" or "lowest" one as desired.
     *
     * If no custom logic is required for the comparison, the simpler `max` or `min` operations
     * can be used instead.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#compare
     *
     * @template V
     *
     * @param callable(T, T): T $comparator
     * @param V $default
     *
     * @return T|V
     */
    public function compare(callable $comparator, $default = null);
}
