<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Appendable.
 */
interface Applyable
{
    /**
     * Apply a callback to all the element of an array.
     *
     * @param callable ...$callables
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function apply(callable ...$callables): Base;
}
