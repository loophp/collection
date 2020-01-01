<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Pluckable.
 */
interface Pluckable
{
    /**
     * @param array<int, string>|string $pluck
     * @param mixed|null $default
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function pluck($pluck, $default = null): Base;
}
