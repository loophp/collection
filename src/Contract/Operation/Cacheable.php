<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @template TKey
 * @template T
 */
interface Cacheable
{
    /**
     * Useful when using a resource as input and you need to run through the collection multiple times.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#cache
     *
     * @return Collection<TKey, T>
     */
    public function cache(?CacheItemPoolInterface $cache = null): Collection;
}
