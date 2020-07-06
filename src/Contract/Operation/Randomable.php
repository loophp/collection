<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Randomable
{
    public function random(int $size = 1): Collection;
}
