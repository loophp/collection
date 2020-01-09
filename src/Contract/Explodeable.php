<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Explodeable.
 */
interface Explodeable
{
    /**
     * Explode a collection into subsets based on a given value.
     *
     * @param mixed ...$explodes
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function explode(...$explodes): Base;
}
