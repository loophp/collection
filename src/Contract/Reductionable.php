<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Reductionable.
 */
interface Reductionable
{
    /**
     * TODO.
     *
     * @param callable $callback
     * @param mixed $initial
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function reduction(callable $callback, $initial = null): Base;
}
