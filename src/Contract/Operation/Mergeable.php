<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Mergeable
{
    /**
     * Merge one or more collection of items onto a collection.
     *
     * @param iterable<mixed> ...$sources
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function merge(iterable ...$sources): Collection;
}
