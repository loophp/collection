<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;
use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Mapable
{
    /**
     * Apply one or more callbacks to a collection and use the return value.
     *
     * @param callable ...$callbacks
     * @psalm-param callable(T, TKey, Iterator<TKey, T>): T ...$callbacks
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function map(callable ...$callbacks): Collection;
}
