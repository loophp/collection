<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Tailable
{
    /**
     * Get last collection items of a collection.
     */
    public function tail(?int $length = null): Collection;
}
