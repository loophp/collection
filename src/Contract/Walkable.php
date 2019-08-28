<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Walkable.
 */
interface Walkable
{
    /**
     * @param callable ...$callbacks
     *
     * @return \drupol\collection\Contract\Collection|\drupol\collection\Contract\Collection
     */
    public function walk(callable ...$callbacks): Collection;
}
