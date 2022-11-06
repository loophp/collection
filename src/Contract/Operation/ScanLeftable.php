<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface ScanLeftable
{
    /**
     * Takes the initial value and the first item of the list and applies the function to them,
     * then feeds the function with this result and the second argument and so on.
     * It returns the list of intermediate and final results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#scanleft
     *
     * @template V
     * @template W
     *
     * @param callable((V|W), T, TKey, iterable<TKey, T>): W $callback
     * @param V $initial
     *
     * @return Collection<TKey, V|W>
     */
    public function scanLeft(callable $callback, $initial): Collection;
}
