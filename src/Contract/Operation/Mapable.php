<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;
use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey of array-key
 * @psalm-template T
 * @psalm-template V
 */
interface Mapable
{
    /**
     * Apply one or more callbacks to a collection and use the return value.
     *
     * @param callable ...$callbacks
     * @psalm-param callable(T, TKey, Iterator<TKey, T>): V ...$callbacks
     *
     * @psalm-return \loophp\collection\Collection<TKey, V>
     */
    public function map(callable ...$callbacks): Collection;
}
