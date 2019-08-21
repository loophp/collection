<?php

declare(strict_types=1);

namespace drupol\collection\Contract\Operation;

/**
 * Interface Appendable.
 */
interface Appendable
{
    /**
     * Add an item to the collection.
     *
     * @param mixed ...$items
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function append(...$items): \Traversable;
}
