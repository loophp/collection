<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Distinctable
{
    /**
     * Remove duplicated values from a collection.
     */
    public function distinct(): Collection;
}
