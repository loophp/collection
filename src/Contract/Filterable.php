<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Filterable.
 */
interface Filterable
{
    /**
     * Filter collection items based on one or more callbacks.
     *
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function filter(callable ...$callbacks): Base;
}
