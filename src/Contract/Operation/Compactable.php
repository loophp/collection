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
interface Compactable
{
    /**
     * Combine a collection of items with some other keys.
     *
     * @param T ...$values
     *
     * @return Collection<TKey, T>
     */
    public function compact(...$values): Collection;
}
