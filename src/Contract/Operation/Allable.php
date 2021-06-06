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
     * Get all items from the collection in the form of an array.
     *
     * @return array<TKey, T>
     */
    public function all(): array;
}
