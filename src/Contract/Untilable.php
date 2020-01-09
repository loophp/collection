<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Untilable.
 */
interface Untilable
{
    /**
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function until(callable ...$callbacks): Base;
}
