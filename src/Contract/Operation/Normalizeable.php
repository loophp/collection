<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Normalizeable
{
    /**
     * Replace, reorder and use numeric keys on a collection.
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function normalize(): Base;
}
