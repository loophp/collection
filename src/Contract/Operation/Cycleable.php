<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Cycleable
{
    public function cycle(?int $length = null): Collection;
}
