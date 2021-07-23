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
interface ScanLeftable
{
    /**
     * Takes the initial value and the first item of the list and applies the function to them,
     * then feeds the function with this result and the second argument and so on.
     * It returns the list of intermediate and final results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#scanleft
     *
     * @param T|null $initial
     *
     * @return Collection<TKey, T>
     */
    public function scanLeft(callable $callback, $initial = null): Collection;
}
