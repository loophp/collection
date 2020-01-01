<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface RSampleable.
 */
interface RSampleable
{
    /**
     * @param float $probability
     *
     * @return \loophp\collection\Contract\Base<mixed>
     */
    public function rsample($probability): Base;
}
