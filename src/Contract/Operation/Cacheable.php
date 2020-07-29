<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Cacheable
{
    /**
     * @return \loophp\collection\Base<TKey, T>|\loophp\collection\Contract\Collection<TKey, T>
     */
    public function cache(?CacheItemPoolInterface $cache = null): Base;
}
