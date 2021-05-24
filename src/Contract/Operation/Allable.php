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
interface Allable
{
    /**
     * Get all items from the collection.
     *
     * @return array<TKey, T>
     *   An array containing all the elements of the collection.
     */
    public function all(): array;
}
