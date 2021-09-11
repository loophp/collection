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
interface Splitable
{
    public const AFTER = 1;

    public const BEFORE = -1;

    public const REMOVE = 0;

    /**
     * Split a collection using one or more callbacks.
     *
     * A flag must be provided in order to specify whether the value used to split the collection
     * should be added at the end of a chunk, at the beginning of a chunk, or completely removed.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#split
     *
     * @param callable ...$callbacks
     *
     * @return Collection<int, list<T>>
     */
    public function split(int $type = Splitable::BEFORE, callable ...$callbacks): Collection;
}
