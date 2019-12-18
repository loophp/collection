<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Pluckable.
 */
interface Pluckable
{
    /**
     * @param array<int, string>|string $pluck
     * @param mixed|null $default
     *
     * @return \drupol\collection\Contract\Collection<mixed>
     */
    public function pluck($pluck, $default = null): Base;
}
