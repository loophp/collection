<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template TKey
 * @psalm-template TKey of array-key
 */
interface Sortable
{
    /**
     * Sort a collection using a callback.
     *
     * @param null|callable(T, T):(int) $callable
     *
     * @return Collection<TKey, T>
     */
    public function sort(?callable $callable = null): Collection;
}
