<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Intersperseable
{
    /**
     * Insert a given value between each element of a collection.
     * Indices are not preserved.
     *
     * @param mixed $element
     * @param int $every
     * @param int $startAt
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): Base;
}
