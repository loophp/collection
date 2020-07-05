<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Mergeable
{
    /**
     * Merge one or more collection of items onto a collection.
     *
     * @param iterable<mixed> ...$sources
     */
    public function merge(iterable ...$sources): Collection;
}
