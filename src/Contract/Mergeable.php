<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

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
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function merge(...$sources): Base;
}
