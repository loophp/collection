<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Mapable.
 */
interface Mapable
{
    /**
     * Apply one or more callbacks to a collection and use the return value.
     *
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function map(callable ...$callbacks): Base;
}
