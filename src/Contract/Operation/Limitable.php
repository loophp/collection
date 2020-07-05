<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Limitable
{
    /**
     * Limit the first {$limit} items.
     */
    public function limit(int $limit): Collection;
}
