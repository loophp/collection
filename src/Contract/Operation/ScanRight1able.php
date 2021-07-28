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
interface ScanRight1able
{
    /**
     * Takes the last two items of the list and applies the function,
     * then it takes the third item from the end and the result, and so on.
     * It returns the list of intermediate and final results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#scanright1
     *
     * @template V
     *
     * @param callable(T|V, T, TKey, Iterator<TKey, T>): V $callback
     *
     * @return Collection<int|TKey, T|V>
     */
    public function scanRight1(callable $callback): Collection;
}
