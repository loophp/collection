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
interface Tailsable
{
    /**
     * Returns the list of initial segments of the collection, shortest last.
     * Similar to applying tail successively and collecting all results in one list.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#tails
     *
     * @return Collection<int, list<T>>
     */
    public function tails(): Collection;
}
