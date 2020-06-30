<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

interface Reduceable
{
    /**
     * Reduce the collection to a single value.
     *
     * @param mixed $initial
     *
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null);
}
