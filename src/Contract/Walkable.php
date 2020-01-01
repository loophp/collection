<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Walkable.
 */
interface Walkable
{
    /**
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function walk(callable ...$callbacks): Base;
}
