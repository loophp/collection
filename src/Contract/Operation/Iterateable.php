<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Iterateable
{
    /**
     * @param mixed ...$parameters
     */
    public static function iterate(callable $callback, ...$parameters): Collection;
}
