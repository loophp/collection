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
     * @return \drupol\collection\Contract\BaseCollection
     */
    public function walk(callable ...$callbacks): BaseCollection;
}
