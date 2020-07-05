<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Nthable
{
    /**
     * Get every n-th element of a collection.
     */
    public function nth(int $step, int $offset = 0): Collection;
}
