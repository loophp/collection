<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

interface FoldLeftable
{
    /**
     * Fold the collection from the left to the right.
     *
     * @param mixed $initial
     * @param callable $callback
     *
     * @return mixed
     */
    public function foldLeft(callable $callback, $initial = null);
}
