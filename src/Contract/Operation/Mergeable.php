<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Mergeable
{
    /**
     * Merge one or more collection of items onto a collection.
     *
     * @param iterable<mixed> ...$sources
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function merge(iterable ...$sources): Base;
}
