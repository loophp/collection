<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Timesable
{
    /**
     * @template T
     *
     * Create a new instance by invoking the callback a given amount of times.
     *
     * @param null|callable(int): (T) $callback
     *
     * @return Collection<int, T>
     */
    public static function times(int $number = 0, ?callable $callback = null): Collection;
}
