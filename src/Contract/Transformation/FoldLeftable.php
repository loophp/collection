<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * Interface FoldLeftable.
 */
interface FoldLeftable
{
    /**
     * Fold the collection from the left to the right.
     *
     * @param callable $callback
     * @param mixed $initial
     *
     * @return mixed
     */
    public function foldLeft(callable $callback, $initial = null);
}
