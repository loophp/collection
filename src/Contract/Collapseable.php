<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Collapseable.
 */
interface Collapseable
{
    /**
     * Collapse a collection of items into a simple flat collection.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function collapse(): Base;
}
