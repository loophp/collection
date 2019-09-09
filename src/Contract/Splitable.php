<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Splitable.
 */
interface Splitable
{
    /**
     * @param callable ...$callbacks
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function split(callable ...$callbacks): Base;
}
