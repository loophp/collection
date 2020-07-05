<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Groupable
{
    public function group(?callable $callback = null): Collection;
}
