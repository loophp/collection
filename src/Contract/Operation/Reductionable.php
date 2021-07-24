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
interface Reductionable
{
    /**
     * Reduce a collection of items through a given callback and yield each intermediary results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#reduction
     *
     * @param mixed $initial
     *
     * @return Collection<TKey, T>
     */
    public function reduction(callable $callback, $initial = null): Collection;
}
