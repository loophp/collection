<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Normalizeable.
 */
interface Normalizeable
{
    /**
     * Reset the keys on the underlying array.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function normalize(): Base;
}
