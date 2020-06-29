<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Combinateable
{
    /**
     * Get all the combinations of a given length of a collection of items.
     *
     * @param int $length
     *   The length.
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function combinate(?int $length = null): Base;
}
