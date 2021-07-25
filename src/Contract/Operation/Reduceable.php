<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;
use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Reduceable
{
    /**
     * Reduce a collection of items through a given callback.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#reduce
     *
     * @template V
     *
     * @param callable(V, T, TKey, Iterator<TKey, T>): V $callback
     * @param V $initial
     *
     * @return Collection<TKey, V>
     */
    public function reduce(callable $callback, $initial = null): Collection;
}
