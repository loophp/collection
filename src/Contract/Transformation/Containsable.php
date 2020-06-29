<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

interface Containsable
{
    /**
     * @param mixed $key
     */
    public function contains($key): bool;
}
