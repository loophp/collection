<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 */
interface Chunkable
{
    /**
     * Chunk the collection into chunks of the given size.
     *
     * @param int ...$size
     *
     * @return Collection<int, array<int, T>>
     */
    public function chunk(int ...$size): Collection;
}
