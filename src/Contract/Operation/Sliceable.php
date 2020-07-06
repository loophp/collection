<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template TKey
 * @psalm-template TKey of array-key
 */
interface Sliceable
{
    /**
     * Get a slice of a collection.
     *
     * @return Collection<TKey, T>
     */
    public function slice(int $offset, ?int $length = null): Collection;
}
