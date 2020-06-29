<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Combineable
{
    /**
     * Combine a collection of items with some other keys.
     *
     * @param mixed ...$keys
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function combine(...$keys): Base;
}
