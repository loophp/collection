<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Closure;
use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Distinctable
{
    /**
     * Remove duplicated values from a collection, preserving keys.
     * The operation has 2 optional parameters that allow you to customize precisely
     * how values are accessed and compared to each other.
     *
     * The first parameter is the comparator. This is a curried function which takes
     * first the left part, then the right part and then returns a boolean.
     *
     * The second parameter is the accessor. This binary function takes the value and the key
     * of the current iterated value and then return the value to compare.
     * This is useful when you want to compare objects.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#distinct
     *
     * @template U
     *
     * @param null|callable(U): (Closure(U): bool) $comparatorCallback
     * @param null|callable(T, TKey): U $accessorCallback
     *
     * @return Collection<TKey, T>
     */
    public function distinct(?callable $comparatorCallback = null, ?callable $accessorCallback = null): Collection;
}
