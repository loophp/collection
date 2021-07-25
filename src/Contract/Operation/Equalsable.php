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
interface Equalsable
{
    /**
     * Compare two collections for equality. Collections are considered equal if:
     * - they have the same number of elements;
     * - they contain the same elements, regardless of the order they appear in or their keys.
     *
     * Elements will be compared using strict equality (`===`). If you want to customize how
     * elements are compared or the order in which the keys/values appear is important, use the `same` operation.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#equals
     *
     * @param Collection<TKey, T> $other
     */
    public function equals(Collection $other): bool;
}
