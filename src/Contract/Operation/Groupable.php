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
interface Groupable
{
    /**
     * Takes a list and returns a list of lists such that the concatenation of the result is equal to the argument.
     * Moreover, each sublist in the result contains only equal elements.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#group
     *
     * @return Collection<int, list<T>>
     */
    public function group(): Collection;
}
