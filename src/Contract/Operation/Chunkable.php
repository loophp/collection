<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Chunkable
{
    /**
     * Chunk the collection into chunks of the given size.
     *
     * @param int ...$size
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function chunk(int ...$size): Base;
}
