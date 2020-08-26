<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Sliceable
{
    /**
     * Get a slice of a collection.
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function slice(int $offset, int $length = -1): Collection;
}
