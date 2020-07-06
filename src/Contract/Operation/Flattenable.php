<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

use const PHP_INT_MAX;

/**
 * @template T
 */
interface Flattenable
{
    /**
     * Flatten a collection of items into a simple flat collection.
     *
     * @return Collection<int, T>
     */
    public function flatten(int $depth = PHP_INT_MAX): Collection;
}
