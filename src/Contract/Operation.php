<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

use Closure;

/**
 * Interface Operation.
 */
interface Operation extends Transformation
{
    /**
     * @param iterable<mixed> $collection
     *
     * @return Closure
     */
    public function on(iterable $collection): Closure;
}
