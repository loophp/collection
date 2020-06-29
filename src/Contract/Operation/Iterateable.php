<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Iterateable
{
    /**
     * @param mixed ...$parameters
     * @param callable $callback
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public static function iterate(callable $callback, ...$parameters): Base;
}
