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
interface Intersperseable
{
    /**
     * Insert a given value at every n element of a collection; indices are not preserved.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#intersperse
     *
     * @param mixed $element
     *
     * @return Collection<TKey, T>
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): Collection;
}
