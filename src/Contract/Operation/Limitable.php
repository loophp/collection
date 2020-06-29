<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Limitable
{
    /**
     * Limit the first {$limit} items.
     *
     * @param int $limit
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function limit(int $limit): Base;
}
