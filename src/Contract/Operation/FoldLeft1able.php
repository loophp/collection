<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface FoldLeft1able
{
    /**
     * Takes the first two items of the list and applies the function to them, then feeds
     * the function with this result and the third argument and so on. See `scanLeft1` for intermediate results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#foldleft1
     *
     * @template V
     *
     * @param callable((T|V), T, TKey, iterable<TKey, T>): V $callback
     *
     * @return V
     */
    public function foldLeft1(callable $callback): mixed;
}
