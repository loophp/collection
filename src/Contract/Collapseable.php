<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Collapseable.
 */
interface Collapseable
{
    /**
     * Collapse the collection of items into a single array.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function collapse(): Base;
}
