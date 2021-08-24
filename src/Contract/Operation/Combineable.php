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
interface Combineable
{
    /**
     * Combine a collection of items with some other keys.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#combine
     *
     * @template U
     *
     * @param U ...$keys
     *
     * @return Collection<U|null, T|null>
     */
    public function combine(...$keys): Collection;
}
