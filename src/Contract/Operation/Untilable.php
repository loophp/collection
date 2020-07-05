<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Untilable
{
    /**
     * @param callable ...$callbacks
     */
    public function until(callable ...$callbacks): Collection;
}
