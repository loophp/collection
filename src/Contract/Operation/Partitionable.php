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
interface Partitionable
{
    /**
     * @param callable(T, TKey):bool ...$callbacks
     *
     * @return \loophp\collection\Collection<int, array<int, array{0: TKey, 1: T}>>
     */
    public function partition(callable ...$callbacks): Collection;
}
