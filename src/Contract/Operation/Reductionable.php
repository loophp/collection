<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Reductionable
{
    /**
     * Reduce a collection of items through a given callback and yield each intermediary results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#reduction
     *
     * @template V
     *
     * @param callable(V, T, TKey, iterable<TKey, T>): V $callback
     * @param V $initial
     *
     * @return Collection<TKey|int, V>
     */
    public function reduction(callable $callback, mixed $initial = null): Collection;
}
