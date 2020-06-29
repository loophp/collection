<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Tailable
{
    /**
     * Get last collection items of a collection.
     *
     * @param int $length
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function tail(int $length = 1): Base;
}
