<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

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
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function filter(callable ...$callbacks): Base;
}
