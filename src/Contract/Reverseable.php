<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Reverseable.
 */
interface Reverseable
{
    /**
     * TODO.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function reverse(): Base;
}
