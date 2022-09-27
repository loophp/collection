<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface AsyncMapable
{
    /**
     * Asynchronously apply a single callback to every item of a collection and use the return value.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#asyncmap
     *
     * @template V
     *
     * @param callable(T, TKey): V $callback
     *
     * @return Collection<TKey, V>
     */
    public function asyncMap(callable $callback): Collection;
}
