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
interface Windowable
{
    /**
     * Loop the collection yielding windows of data by adding a given number of items to the current item.
     * Initially the windows yielded will be smaller, until size `1 + $size` is reached.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#window
     *
     * @return Collection<TKey, list<T>>
     */
    public function window(int $size): Collection;
}
