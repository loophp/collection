<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Explodeable.
 */
interface Explodeable
{
    /**
     * @param string ...$explodes
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function explode(string ...$explodes): Base;
}
