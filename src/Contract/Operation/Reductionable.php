<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Reductionable.
 */
interface Reductionable
{
    /**
     * Reduce a collection of items through a given callback.
     *
     * @param callable $callback
     * @param mixed $initial
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function reduction(callable $callback, $initial = null): Base;
}
