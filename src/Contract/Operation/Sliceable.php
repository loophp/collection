<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Sliceable
{
    /**
     * Get a slice of a collection.
     *
     * @param int $offset
     * @param ?int $length
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function slice(int $offset, ?int $length = null): Base;
}
