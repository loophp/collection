<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Mergeable.
 */
interface Mergeable
{
    /**
     * Push all of the given items onto the collection.
     *
     * @param iterable ...$sources
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function merge(...$sources): Base;
}
