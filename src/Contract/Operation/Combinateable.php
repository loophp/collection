<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Combinateable
{
    /**
     * Get all the combinations of a given length of a collection of items.
     *
     * @param ?int $length
     */
    public function combinate(?int $length = null): Collection;
}
