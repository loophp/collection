<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface ScanLeft1able
{
    /**
     * Takes the first two items of the list and applies the function to them,
     * then feeds the function with this result and the third argument and so on.
     * It returns the list of intermediate and final results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#scanleft1
     *
     * @template V
     *
     * @param callable((T|V), T, TKey, iterable<TKey, T>): (T|V) $callback
     *
     * @return Collection<TKey, T|V>
     */
    public function scanLeft1(callable $callback): Collection;
}
