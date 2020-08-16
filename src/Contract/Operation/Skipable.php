<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Skipable
{
    /**
     * Skip the n items of a collection.
     *
     * @param int ...$counts
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function skip(int ...$counts): Collection;
}
