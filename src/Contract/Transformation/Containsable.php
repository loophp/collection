<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * @psalm-template T
 */
interface Containsable
{
    /**
     * @param mixed $value
     * @psalm-param T $value
     */
    public function contains($value): bool;
}
