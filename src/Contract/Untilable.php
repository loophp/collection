<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Untilable.
 */
interface Untilable
{
    /**
     * @param callable $callable
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function until(callable $callable): Base;
}
