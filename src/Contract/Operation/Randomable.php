<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Randomable
{
    /**
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function random(int $size = 1): Base;
}
