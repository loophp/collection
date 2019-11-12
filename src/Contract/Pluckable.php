<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Pluckable.
 */
interface Pluckable
{
    /**
     * @param array|string $pluck
     * @param mixed|null $default
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function pluck($pluck, $default = null): Base;
}
