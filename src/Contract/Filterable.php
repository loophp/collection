<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Filterable.
 */
interface Filterable
{
    /**
     * Run a filter over each of the items.
     *
     * @param callable ...$callbacks
     *
     * @return \drupol\collection\Contract\Collection<mixed>
     */
    public function filter(callable ...$callbacks): Base;
}
