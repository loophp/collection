<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Walkable
{
    /**
     * Apply one or more supplied callbacks to every item of a collection.
     *
     * @param callable ...$callbacks
     */
    public function walk(callable ...$callbacks): Collection;
}
