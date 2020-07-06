<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Diffkeysable
{
    /**
     * @param mixed ...$values
     */
    public function diffKeys(...$values): Collection;
}
