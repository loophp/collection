<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Sliceable
{
    /**
     * Get a slice of a collection.
     */
    public function slice(int $offset, ?int $length = null): Collection;
}
