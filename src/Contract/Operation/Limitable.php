<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Limitable.
 */
interface Limitable
{
    /**
     * Limit the first {$limit} items.
     *
     * @param int $limit
     *
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function limit(int $limit): Base;
}
