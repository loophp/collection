<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Sliceable
{
    /**
     * Get a slice of a collection.
     *
     * @param ?int $length
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function slice(int $offset, ?int $length = null): Collection;
}
