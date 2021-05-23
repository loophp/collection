<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey of array-key
 * @template T
 */
interface Pluckable
{
    /**
     * Retrieves all of the values of a collection for a given key.
     *
     * @param array<int, string>|array-key $pluck
     * @param mixed|null $default
     *
     * @return \loophp\collection\Collection<TKey, T>
     */
    public function pluck($pluck, $default = null): Collection;
}
