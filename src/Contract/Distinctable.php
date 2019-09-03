<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Distinctable.
 */
interface Distinctable
{
    /**
     * @return \drupol\collection\Contract\Base
     */
    public function distinct(): Base;
}
