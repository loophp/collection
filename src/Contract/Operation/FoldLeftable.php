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
 * @template TKey
 * @template T
 */
interface FoldLeftable
{
    /**
     * Fold the collection from the left to the right.
     *
     * @param callable(T, T, TKey, Iterator<TKey, T>): T $callback
     * @param T|null $initial
     *
     * @return \loophp\collection\Collection<TKey, T|null>
     */
    public function foldLeft(callable $callback, $initial = null): Collection;
}
