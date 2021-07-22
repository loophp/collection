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
interface Untilable
{
    /**
     * Iterate over the collection items until the provided callback(s) are satisfied.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#until
     *
     * @param callable(T, TKey):bool ...$callbacks
     *
     * @return Collection<TKey, T>
     */
    public function until(callable ...$callbacks): Collection;
}
