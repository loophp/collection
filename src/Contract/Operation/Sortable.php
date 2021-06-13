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
interface Sortable
{
    public const BY_KEYS = 1;

    public const BY_VALUES = 0;

    /**
     * Sort a collection using a callback.
     *
     * @return Collection<TKey, T>
     */
    public function sort(int $type = Sortable::BY_VALUES, ?callable $callback = null): Collection;
}
