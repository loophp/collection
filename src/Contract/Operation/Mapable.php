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
 * @template V
 */
interface Mapable
{
    /**
     * Apply one or more callbacks to a collection and use the return value.
     *
     * @psalm-param callable(T, TKey, Iterator<TKey, T>): V ...$callbacks
     *
     * @return \loophp\collection\Collection<TKey, V>
     */
    public function map(callable ...$callbacks): Collection;
}
