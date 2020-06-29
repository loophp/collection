<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Walkable
{
    /**
     * Apply one or more supplied callbacks to every item of a collection.
     *
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function walk(callable ...$callbacks): Base;
}
