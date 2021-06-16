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
     * @param null|callable(mixed): (Closure(mixed): bool) $comparatorCallback
     * @param null|callable(T, TKey): mixed $accessorCallback
     *
     * @return Collection<TKey, T>
     */
    public function distinct(?callable $comparatorCallback = null, ?callable $accessorCallback = null): Collection;
}
