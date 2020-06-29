<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Collapseable
{
    /**
     * Collapse a collection of items into a simple flat collection.
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function collapse(): Base;
}
