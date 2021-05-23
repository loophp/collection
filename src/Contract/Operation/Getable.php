<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey of array-key
 * @template T
 */
interface Getable
{
    /**
     * Get an item by key.
     *
     * @param int|string $key
     * @psalm-param TKey $key
     *
     * @param mixed $default
     * @psalm-param T|null $default
     *
     * @psalm-return \loophp\collection\Collection<TKey, T|null>
     */
    public function get($key, $default = null): Collection;
}
