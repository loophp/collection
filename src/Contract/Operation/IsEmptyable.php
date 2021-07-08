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
     * Check if the collection contains any elements.
     */
    public function isEmpty(): bool;
}
