<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface RSampleable
{
    public function rsample(float $probability): Collection;
}
