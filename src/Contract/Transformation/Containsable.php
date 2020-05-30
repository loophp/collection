<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

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
