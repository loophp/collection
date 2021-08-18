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
interface Productable
{
    /**
     * Get the the cartesian product of items of a collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#product
     *
     * @template UKey
     * @template U
     *
     * @param iterable<UKey, U> ...$iterables
     *
     * @return Collection<TKey, list<T|U>>
     */
    public function product(iterable ...$iterables): Collection;
}
