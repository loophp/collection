<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Containsable.
 */
interface Containsable
{
    /**
     * @param mixed $key
     *
     * @return bool
     */
    public function contains($key): bool;
}
