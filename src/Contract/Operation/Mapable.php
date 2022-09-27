<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;
use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Mapable
{
    /**
     * Apply a single callback to every item of a collection and use the return value.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#map
     *
     * @param callable(T=, TKey=, Iterator<TKey, T>=): mixed $callback
     *
     * @return Collection<TKey, mixed>
     */
    public function map(callable $callback): Collection;
}
