<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Intersectkeysable
{
    /**
     * @param mixed ...$values
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function intersectKeys(...$values): Base;
}
