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
     * @template W
     *
     * @param callable((V|W)=, T=, TKey=, iterable<TKey, T>=): W $callback
     * @param V $initial
     *
     * @return V|W
     */
    public function foldLeft(callable $callback, $initial);
}
