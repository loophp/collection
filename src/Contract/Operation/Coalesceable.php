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
interface Coalesceable
{
    /**
     * Return the first non-nullsy value in a collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#coalesce
     *
     * @return Collection<TKey, T>
     */
    public function coalesce(): Collection;
}
