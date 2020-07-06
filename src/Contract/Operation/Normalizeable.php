<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 */
interface Normalizeable
{
    /**
     * Replace, reorder and use numeric keys on a collection.
     *
     * @return Collection<int, T>
     */
    public function normalize(): Collection;
}
