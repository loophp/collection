<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Filterable
{
    /**
     * Filter collection items based on one or more callbacks.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#filter
     *
     * @param callable(T, TKey, iterable<TKey, T>): bool ...$callbacks
     *
     * @return Collection<TKey, T>
     */
    public function filter(callable ...$callbacks): Collection;
}
