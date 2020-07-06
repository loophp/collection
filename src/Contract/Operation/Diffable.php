<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Diffable
{
    /**
     * @param mixed ...$values
     */
    public function diff(...$values): Collection;
}
