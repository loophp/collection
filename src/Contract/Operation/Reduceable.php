<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Reduceable
{
    /**
     * Reduce a collection of items through a given callback.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#reduce
     *
     * @template V
     *
     * @param callable(V, T, TKey, iterable<TKey, T>): V $callback
     * @param V $initial
     *
     * @return V
     */
    public function reduce(callable $callback, mixed $initial = null);
}
