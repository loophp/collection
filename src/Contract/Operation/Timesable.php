<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Timesable
{
    /**
     * Create a new instance by invoking the callback a given amount of times.
     *
     * @param int $number
     * @param callable|null $callback
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public static function times(int $number = 0, ?callable $callback = null): Base;
}
