<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Timesable
{
    /**
     * Create a new instance by invoking the callback a given amount of times.
     *
     * @template TKey
     * @psalm-template TKey of array-key
     * @template T
     *
     * @return \loophp\collection\Base<TKey, T>|\loophp\collection\Contract\Collection<TKey, T>
     */
    public static function times(int $number = 0, ?callable $callback = null): Base;
}
