<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Chunkable
{
    /**
     * Chunk a collection of items into chunks of items of a given size.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#chunk
     *
     * @return Collection<int, list<T>>
     */
    public function chunk(int ...$sizes): Collection;
}
