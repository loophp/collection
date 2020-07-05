<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Skipable
{
    /**
     * Skip the n items of a collection.
     *
     * @param int ...$counts
     */
    public function skip(int ...$counts): Collection;
}
