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
interface Headable
{
    /**
     * Get the first item from the collection in a separate collection. Same as `first`.
     *
     * The `current` operation can then be used to extract the item out of the collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#head
     *
     * @return Collection<TKey, T>
     */
    public function head(): Collection;
}
