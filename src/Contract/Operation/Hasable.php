<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;
use loophp\collection\Contract\Collection;

/**
 * @template TKey of array-key
 * @template T
 */
interface Hasable
{
    /**
     * @param callable(T, TKey, Iterator<TKey, T>): bool ...$callbacks
     *
     * @return \loophp\collection\Collection<int, bool>
     */
    public function has(callable ...$callbacks): Collection;
}
