<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;

/**
 * @template TKey
 * @template T
 */
interface Findable
{
    /**
     * Find a value in the collection that matches all predicates or return the
     * default value.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#find
     *
     * @template V
     *
     * @param V $default
     * @param (callable(T=, TKey=, Iterator<TKey, T>=): bool) ...$callbacks
     *
     * @return T|V
     */
    public function find($default = null, callable ...$callbacks);
}
