<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * Interface Reduceable.
 */
interface Reduceable
{
    /**
     * Reduce the collection to a single value.
     *
     * @param callable $callback
     * @param mixed $initial
     *
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null);
}
