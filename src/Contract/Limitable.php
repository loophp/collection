<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

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
     * @return \drupol\collection\Contract\Collection
     */
    public function limit(int $limit): Base;
}
