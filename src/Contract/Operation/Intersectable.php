<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Intersectable
{
    /**
     * @param mixed ...$values
     */
    public function intersect(...$values): Collection;
}
