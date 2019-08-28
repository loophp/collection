<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Sortable.
 */
interface Sortable
{
    /**
     * Sort the collection using a callback.
     *
     * @param callable $callable
     *
     * @return \drupol\collection\Contract\BaseCollection
     */
    public function sort(callable $callable): BaseCollection;
}
