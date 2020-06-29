<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface RSampleable
{
    public function rsample(float $probability): Base;
}
