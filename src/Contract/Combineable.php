<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Combineable.
 */
interface Combineable
{
    /**
     * @param mixed $keys
     *
     * @return \drupol\collection\Contract\BaseCollection
     */
    public function combine($keys): BaseCollection;
}
