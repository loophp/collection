<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

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
     * @return \drupol\collection\Contract\Collection<mixed>
     */
    public function append(...$items): Base;
}
