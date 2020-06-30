<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

interface FoldRightable
{
    /**
     * Fold the collection from the right to the left.
     *
     * @param mixed $initial
     *
     * @return mixed
     */
    public function foldRight(callable $callback, $initial = null);
}
