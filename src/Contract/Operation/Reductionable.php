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
interface Reductionable
{
    /**
     * Reduce a collection of items through a given callback and
     * and yield each intermediary results.
     *
     * @template V
     *
     * @param callable((V|null), T, TKey, Iterator<TKey, T>): (V|null) $callback
     * @param V|null $initial
     *
     * @return Collection<TKey, (V|null)>
     */
    public function reduction(callable $callback, $initial = null): Collection;
}
