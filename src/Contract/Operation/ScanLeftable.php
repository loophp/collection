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
interface ScanLeftable
{
    /**
     * Takes the initial value and the first item of the list and applies the function to them,
     * then feeds the function with this result and the second argument and so on.
     * It returns the list of intermediate and final results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#scanleft
     *
     * @template V
     * @template W
     *
     * @param callable((V|W)=, T=, TKey=, Iterator<TKey, T>=): W $callback
     * @param V $initial
     *
     * @return Collection<int|TKey, V|W>
     */
    public function scanLeft(callable $callback, $initial = null): Collection;
}
