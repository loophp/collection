<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Timesable
{
    /**
     * Create a collection by invoking a callback a given amount of times.
     * If no callback is provided, then it will create a simple list of incremented integers.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#times
     *
     * @template T
     *
     * @param callable(int): T $callback
     *
     * @return Collection<int, T>
     */
    public static function times(int $number = 0, ?callable $callback = null): Collection;
}
