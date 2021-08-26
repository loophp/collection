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
interface Applyable
{
    /**
     * Execute callback(s) on each element of the collection.
     * Iterates on the collection items regardless of the return value of the callback.
     * If the callback does not return `true` then it stops applying callbacks on subsequent items.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#apply
     *
     * @param callable(T=, TKey=, Iterator<TKey, T>=): bool ...$callbacks
     *
     * @return Collection<TKey, T>
     */
    public function apply(callable ...$callbacks): Collection;
}
