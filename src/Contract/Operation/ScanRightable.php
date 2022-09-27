<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface ScanRightable
{
    /**
     * Takes the initial value and the last item of the list and applies the function,
     * then it takes the penultimate item from the end and the result, and so on.
     * It returns the list of intermediate and final results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#scanright
     *
     * @param callable(mixed=, T=, TKey=, iterable<TKey, T>=): mixed $callback
     * @param mixed $initial
     *
     * @return Collection<int|TKey, mixed>
     */
    public function scanRight(callable $callback, $initial = null): Collection;
}
