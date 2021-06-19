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
interface MapNable
{
    /**
     * Apply one or more callbacks to a collection and use the return value.
     *
     * @param callable(mixed, mixed, Iterator<TKey, T>): mixed ...$callbacks
     *
     * @return Collection<mixed, mixed>
     */
    public function mapN(callable ...$callbacks): Collection;
}
