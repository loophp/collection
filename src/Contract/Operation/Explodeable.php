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
interface Explodeable
{
    /**
     * Explode a collection into subsets based on a given value.
     * This operation uses the `split` operation with the flag `Splitable::REMOVE` and thus,
     * values used to explode the collection are removed from the chunks.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#explode
     *
     * @param mixed ...$explodes
     *
     * @return Collection<int, list<T>>
     */
    public function explode(...$explodes): Collection;
}
