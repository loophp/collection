<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Timesable
{
    /**
     * Create a new instance by invoking the callback a given amount of times.
     *
     * @psalm-template TKey
     * @psalm-template TKey of array-key
     * @psalm-template T
     *
     * @psalm-param null|callable(): T $callback
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public static function times(int $number = 0, ?callable $callback = null): Collection;
}
