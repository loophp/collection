<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Diffkeysable
{
    /**
     * @param mixed ...$values
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function diffKeys(...$values): Base;
}
