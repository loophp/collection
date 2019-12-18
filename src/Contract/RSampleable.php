<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface RSampleable.
 */
interface RSampleable
{
    /**
     * @param float $probability
     *
     * @return \drupol\collection\Contract\Base<mixed>
     */
    public function rsample($probability): Base;
}
