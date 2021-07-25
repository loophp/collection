<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Containsable
{
    /**
     * Check if the collection contains one or more values.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#contains
     *
     * @param T ...$values
     */
    public function contains(...$values): bool;
}
