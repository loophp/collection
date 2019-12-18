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
     * @return \drupol\collection\Contract\Collection<mixed>
     */
    public function until(callable $callable): Base;
}
