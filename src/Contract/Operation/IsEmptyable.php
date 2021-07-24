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
interface IsEmptyable
{
    /**
     * Check if a collection has any elements inside.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#isempty
     */
    public function isEmpty(): bool;
}
