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
interface Strictable
{
    /**
     * @param null|callable(mixed): string $callback
     *
     * @return Collection<TKey, T>
     */
    public function strict(?callable $callback = null): Collection;
}
