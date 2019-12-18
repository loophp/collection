<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Distinctable.
 */
interface Distinctable
{
    /**
     * @return \drupol\collection\Contract\Base<mixed>
     */
    public function distinct(): Base;
}
