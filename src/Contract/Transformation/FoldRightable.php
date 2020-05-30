<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * Interface FoldRightable.
 */
interface FoldRightable
{
    /**
     * Fold the collection from the right to the left.
     *
     * @param callable $callback
     * @param mixed $initial
     *
     * @return mixed
     */
    public function foldRight(callable $callback, $initial = null);
}
