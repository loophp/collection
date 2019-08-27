<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Mapable.
 */
interface Mapable
{
    /**
     * Run a map over each of the items.
     *
     * @param callable ...$callbacks
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function map(callable ...$callbacks): Collection;
}
