<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Columnable
{
    /**
     * Return the values from a single column in the input iterables.
     *
     * @param int|string $index
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function column($index): Base;
}
