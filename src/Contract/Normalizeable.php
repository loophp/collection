<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Normalizeable.
 */
interface Normalizeable
{
    /**
     * Replace, reorder and use numeric keys on a collection.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function normalize(): Base;
}
