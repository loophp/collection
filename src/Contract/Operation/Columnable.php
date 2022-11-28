<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Columnable
{
    /**
     * Return the values from a single column in the input iterables.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#column
     *
     * @return Collection<int, mixed>
     */
    public function column(mixed $column): Collection;
}
