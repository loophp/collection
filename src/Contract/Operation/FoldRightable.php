<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface FoldRightable
{
    /**
     * Takes the initial value and the last item of the list and applies the function, then it takes
     * the penultimate item from the end and the result, and so on. See scanRight for intermediate results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#foldright
     *
     * @template V
     *
     * @param callable(V, T, TKey, iterable<TKey, T>): V $callback
     * @param V $initial
     *
     * @return V
     */
    public function foldRight(callable $callback, mixed $initial): mixed;
}
