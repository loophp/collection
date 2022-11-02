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
     * Group items based on their keys.
     * The default behaviour can be customized with a callback.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#groupby
     *
     * @template NewTKey
     *
     * @param callable(T=, TKey=): NewTKey $callable
     *
     * @return Collection<NewTKey, non-empty-list<T>>
     */
    public function groupBy(callable $callable): Collection;
}
