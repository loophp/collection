<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface RSampleable.
 */
interface RSampleable
{
    /**
     * @param float $probability
     *
     * @return \loophp\collection\Contract\Base
     */
    public function rsample($probability): Base;
}
