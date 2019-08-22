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
     * @param null|mixed $default
     *
     * @return \drupol\collection\Contract\BaseCollection
     */
    public function pluck($pluck, $default = null): BaseCollection;
}
