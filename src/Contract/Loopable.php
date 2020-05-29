<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Loopable.
 */
interface Loopable
{
    /**
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function loop(): Base;
}
