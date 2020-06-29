<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

interface Reduceable
{
    /**
     * Reduce the collection to a single value.
     *
     * @param mixed $initial
     * @param callable $callback
     *
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null);
}
