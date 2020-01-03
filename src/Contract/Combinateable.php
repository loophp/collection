<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Combinateable.
 */
interface Combinateable
{
    /**
     * TODO: Combinations.
     *
     * @param int $size
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function combinate(?int $size = null): Base;
}
