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
interface Combinateable
{
    /**
     * Get all the combinations of a given length of a collection of items.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#combinate
     *
     * @return Collection<TKey, T>
     */
    public function combinate(?int $length = null): Collection;
}
