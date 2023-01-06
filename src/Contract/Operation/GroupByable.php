<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface GroupByable
{
    /**
     * Group items based on a custom callback.
     * The grouping will be based on the returned value of the callback.
     * The callback takes two parameters, the value and the key of the current
     * item in the iterator, the returned value must be an integer or a string.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#groupby
     *
     * @param callable(T, TKey): array-key $callback
     *
     * @return Collection<array-key, non-empty-list<T>>
     */
    public function groupBy(callable $callback): Collection;
}
