<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Reverseable
{
    /**
     * Reverse order items of a collection.
     */
    public function reverse(): Collection;
}
