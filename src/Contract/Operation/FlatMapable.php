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
interface FlatMapable
{
    /**
     * Transform the collection through a callback and flatten one level.
     *
     * @template V
     *
     * @param callable(T, TKey, Iterator<TKey, T>): V $callback
     *
     * @return Collection<TKey, V>
     */
    public function flatMap(callable $callback): Collection;
}
