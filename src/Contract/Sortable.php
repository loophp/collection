<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

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
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function sort(callable $callable): Base;
}
