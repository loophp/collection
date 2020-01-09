<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Reverseable.
 */
interface Reverseable
{
    /**
     * Reverse order items of a collection.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function reverse(): Base;
}
