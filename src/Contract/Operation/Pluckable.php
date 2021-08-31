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
interface Pluckable
{
    /**
     * Retrieves all of the values of a collection for a given key.
     * Nested values can be retrieved using “dot notation” and the wildcard character `*`.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#pluck
     *
     * @param array<int, string>|array-key $pluck
     * @param mixed|null $default
     *
     * @return Collection<int, iterable<int, T>|T>
     */
    public function pluck($pluck, $default = null): Collection;
}
