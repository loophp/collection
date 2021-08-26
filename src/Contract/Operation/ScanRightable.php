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
interface ScanRightable
{
    /**
     * Takes the initial value and the last item of the list and applies the function,
     * then it takes the penultimate item from the end and the result, and so on.
     * It returns the list of intermediate and final results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#scanright
     *
     * @template V
     * @template W
     *
     * @param callable((V|W)=, T=, TKey=, Iterator<TKey, T>=): W $callback
     * @param V $initial
     *
     * @return Collection<int|TKey, V|W>
     */
    public function scanRight(callable $callback, $initial = null): Collection;
}
