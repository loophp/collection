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
interface TakeWhileable
{
    /**
     * Iterate over the collection items while the provided callback(s) are satisfied.
     * It stops iterating when the callback(s) are not met.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#takewhile
     *
     * @param callable(T=, TKey=, Iterator<TKey, T>=): bool ...$callbacks
     *
     * @return Collection<TKey, T>
     */
    public function takeWhile(callable ...$callbacks): Collection;
}
