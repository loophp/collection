<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Keysable.
 */
interface Keysable
{
    /**
     * Get the keys of the items.
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function keys(): Base;
}
