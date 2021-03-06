<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Closure;
use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Distinctable
{
    /**
     * @template U
     *
     * @param null|callable(U): (Closure(U): bool) $comparatorCallback
     * @param null|callable(T, TKey): U $accessorCallback
     *
     * @return Collection<TKey, T>
     */
    public function distinct(?callable $comparatorCallback = null, ?callable $accessorCallback = null): Collection;
}
