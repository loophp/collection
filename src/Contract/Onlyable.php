<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Onlyable.
 */
interface Onlyable
{
    /**
     * Get the items with the specified keys.
     *
     * @param mixed ...$keys
     *
     * @return \drupol\collection\Contract\BaseCollection
     */
    public function only(...$keys): BaseCollection;
}
