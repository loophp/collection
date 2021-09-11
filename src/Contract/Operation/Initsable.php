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
interface Initsable
{
    /**
     * Returns all initial segments of the collection, shortest first.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#inits
     *
     * @return Collection<int, list<array{0: TKey, 1: T}>>
     */
    public function inits(): Collection;
}
