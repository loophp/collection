<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;

/**
 * @template TKey
 * @template T
 */
interface Hasable
{
    /**
     * Check if the collection has values with the help of one or more callables.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#has
     *
     * @param callable(T=, TKey=, Iterator<TKey, T>=): T ...$callbacks
     */
    public function has(callable ...$callbacks): bool;
}
