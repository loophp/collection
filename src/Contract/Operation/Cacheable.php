<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;
use Psr\Cache\CacheItemPoolInterface;

interface Cacheable
{
    public function cache(?CacheItemPoolInterface $cache = null): Base;
}
