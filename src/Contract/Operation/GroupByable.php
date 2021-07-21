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
interface GroupByable
{
    /**
     * Group items based on their keys.
     * The default behaviour can be customized with a callback.
     *
     * @see https://loophp-collection.readthedocs.io/en/latest/pages/api.html#groupby
     *
     * @return Collection<TKey, T>
     */
    public function groupBy(?callable $callable = null): Collection;
}
