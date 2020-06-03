<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Sliceable.
 */
interface Sliceable
{
    /**
     * Get a slice of a collection.
     *
     * @param int $offset
     * @param int|null $length
     *
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function slice(int $offset, ?int $length = null): Base;
}
