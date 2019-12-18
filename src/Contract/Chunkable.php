<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Chunkable.
 */
interface Chunkable
{
    /**
     * Chunk the collection into chunks of the given size.
     *
     * @param int $size
     *
     * @return \drupol\collection\Contract\Collection<mixed>
     */
    public function chunk(int $size): Base;
}
