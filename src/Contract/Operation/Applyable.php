<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;
use Iterator;

/**
 * @template TKey
 * @template T
 */
interface Applyable
{
    /**
     * Execute a callback for each element of the collection.
     *
     * @param callable(T, TKey, Iterator<TKey, T>): bool ...$callbacks
     *
     * @return Collection<TKey, T>
     */
    public function apply(callable ...$callbacks): Collection;
}
