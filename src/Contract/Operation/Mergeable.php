<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey of array-key
 * @template T
 */
interface Mergeable
{
    /**
     * Merge one or more collection of items onto a collection.
     *
     * @param iterable<mixed> ...$sources
     *
     * @return \loophp\collection\Collection<TKey, T>
     */
    public function merge(iterable ...$sources): Collection;
}
