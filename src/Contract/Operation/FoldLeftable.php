<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface FoldLeftable
{
    /**
     * Takes the initial value and the first item of the list and applies the function to them, then feeds
     * the function with this result and the second argument and so on. See `scanLeft` for intermediate results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#foldleft
     *
     * @template V
     *
     * @param callable(V, T, TKey, iterable<TKey, T>): V $callback
     * @param V $initial
     *
     * @return V
     */
    public function foldLeft(callable $callback, mixed $initial);
}
