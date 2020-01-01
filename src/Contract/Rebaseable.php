<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Rebaseable.
 */
interface Rebaseable
{
    /**
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function rebase(): Base;
}
