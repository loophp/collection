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
interface Shuffleable
{
    /**
     * Shuffle a collection, randomly changing the order of items.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#shuffle
     *
     * @return Collection<TKey, T>
     */
    public function shuffle(): Collection;
}
