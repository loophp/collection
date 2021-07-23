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
interface Padable
{
    /**
     * Pad a collection to the given length with a given value.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#pad
     *
     * @param mixed $value
     *
     * @return Collection<int|TKey, T>
     */
    public function pad(int $size, $value): Collection;
}
