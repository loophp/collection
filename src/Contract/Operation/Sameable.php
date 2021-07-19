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
interface Sameable
{
    /**
     * Check if the collection is the same as another collection.
     *
     * @param Collection<TKey, T> $other
     * @param null|callable(T, TKey): (Closure(T, TKey): bool) $comparatorCallback
     */
    public function same(Collection $other, ?callable $comparatorCallback = null): bool;
}
