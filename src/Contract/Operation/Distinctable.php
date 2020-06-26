<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Distinctable.
 */
interface Distinctable
{
    /**
     * Remove duplicated values from a collection.
     *
     * @return \loophp\collection\Contract\Base
     */
    public function distinct(): Base;
}
