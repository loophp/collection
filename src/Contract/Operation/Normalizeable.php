<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Normalizeable
{
    /**
     * Replace, reorder and use numeric keys on a collection.
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function normalize(): Collection;
}
