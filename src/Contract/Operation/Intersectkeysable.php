<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Intersectkeysable
{
    /**
     * @param mixed ...$values
     */
    public function intersectKeys(...$values): Collection;
}
