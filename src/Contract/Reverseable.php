<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Reverseable.
 */
interface Reverseable
{
    /**
     * TODO.
     *
     * @return \drupol\collection\Contract\Collection<mixed>
     */
    public function reverse(): Base;
}
