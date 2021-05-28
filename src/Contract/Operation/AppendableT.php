<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\CollectionT;

/**
 * @template TKey
 * @template T
 */
interface AppendableT
{
    /**
     * Add one or more items to a collection.
     *
     * @template U of T
     *
     * @param U ...$items
     *
     * @return CollectionT<int|TKey, T|U>
     */
    public function append(...$items): CollectionT;
}
