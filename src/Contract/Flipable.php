<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Flipable.
 */
interface Flipable
{
    /**
     * Flip the items in the collection.
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function flip(): Collection;
}
