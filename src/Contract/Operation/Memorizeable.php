<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @template TKey
 * @template T
 */
interface Memorizeable
{
    /**
     * Memorize the collection in memory so it can be iterated multiple times.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#memorize
     *
     * @return Collection<TKey, T>
     */
    public function memorize(): Collection;
}
