<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Cycleable
{
    /**
     * @param int $length
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function cycle(int $length = 0): Base;
}
