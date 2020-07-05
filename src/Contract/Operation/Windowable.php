<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Windowable
{
    /**
     * @param int ...$length
     */
    public function window(int ...$length): Collection;
}
