<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Iterateable
{
    /**
     * @template TKey
     * @psalm-template TKey of array-key
     * @template T
     *
     * @param mixed ...$parameters
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public static function iterate(callable $callback, ...$parameters): Collection;
}
