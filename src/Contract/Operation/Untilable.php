<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Untilable.
 */
interface Untilable
{
    /**
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function until(callable ...$callbacks): Base;
}
