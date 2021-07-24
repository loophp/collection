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
interface Lastable
{
    /**
     * Extract the last element of a collection, which must be finite and non-empty.
     *
     * The `current` operation can then be used to extract the item out of the collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#last
     *
     * @return Collection<TKey, T>
     */
    public function last(): Collection;
}
