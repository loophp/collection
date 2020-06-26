<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Iterateable.
 */
interface Iterateable
{
    /**
     * @param callable $callback
     * @param mixed ...$parameters
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public static function iterate(callable $callback, ...$parameters): Base;
}
