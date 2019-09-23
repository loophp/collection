<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Operation.
 */
interface Operation extends Transformation
{
    /**
     * @param iterable $collection
     *
     * @return \Closure
     */
    public function on(iterable $collection): \Closure;
}
