<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Cycleable
{
    /**
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function cycle(?int $length = null): Collection;
}
