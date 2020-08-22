<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Firstable
{
    /**
     * Get the first item from the collection passing the given truth test.
     *
     * @psalm-param null|callable(T, TKey):(bool) $callback
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function first(?callable $callback = null, int $size = 1): Collection;
}
