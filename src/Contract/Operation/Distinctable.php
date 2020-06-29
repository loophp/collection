<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Distinctable
{
    /**
     * Remove duplicated values from a collection.
     */
    public function distinct(): Base;
}
