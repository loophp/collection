<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Windowable.
 */
interface Windowable
{
    /**
     * @param int ...$length
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function window(int ...$length): Base;
}
