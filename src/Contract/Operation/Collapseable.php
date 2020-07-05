<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Collapseable
{
    /**
     * Collapse a collection of items into a simple flat collection.
     */
    public function collapse(): Collection;
}
