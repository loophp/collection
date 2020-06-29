<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Reverseable
{
    /**
     * Reverse order items of a collection.
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function reverse(): Base;
}
