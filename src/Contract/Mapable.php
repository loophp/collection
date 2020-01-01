<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

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
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function map(callable ...$callbacks): Base;
}
