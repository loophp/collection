<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Reductionable
{
    /**
     * Reduce a collection of items through a given callback.
     *
     * @param mixed $initial
     * @param callable $callback
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function reduction(callable $callback, $initial = null): Base;
}
