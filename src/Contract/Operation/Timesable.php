<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Timesable
{
    /**
     * Create a new instance by invoking the callback a given amount of times.
     */
    public static function times(int $number = 0, ?callable $callback = null): Collection;
}
