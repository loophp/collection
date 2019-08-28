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
     * @return \drupol\collection\Contract\BaseCollection
     */
    public function keys(): BaseCollection;
}
