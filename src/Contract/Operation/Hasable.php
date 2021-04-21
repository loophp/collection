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
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Hasable
{
    /**
     * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool ...$callbacks
     *
     * @psalm-return \loophp\collection\Collection<int, bool>
     */
    public function has(callable ...$callbacks): Collection;
}
