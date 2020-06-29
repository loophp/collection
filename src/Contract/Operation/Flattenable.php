<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

use const PHP_INT_MAX;

interface Flattenable
{
    /**
     * Flatten a collection of items into a simple flat collection.
     *
     * @param int $depth
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function flatten(int $depth = PHP_INT_MAX): Base;
}
