<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Normalizeable
{
    /**
     * Replace, reorder and use numeric keys on a collection.
     */
    public function normalize(): Collection;
}
