<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Mergeable.
 */
interface Mergeable
{
    /**
     * Merge one or more collection of items onto a collection.
     *
     * @param iterable ...$sources
     *
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function merge(iterable ...$sources): Base;
}
