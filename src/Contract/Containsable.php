<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

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
