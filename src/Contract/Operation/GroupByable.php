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
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#groupby
     *
     * @template NewTKey
     *
     * @param null|callable(T=, TKey=): NewTKey|null $callable
     *
     * @return Collection<TKey|NewTKey, T|non-empty-list<T>>
     */
    public function groupBy(?callable $callable = null): Collection;
}
