<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Intersectkeysable
{
    /**
     * Removes any keys from the original collection that are not present in the given keys set.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#intersectkeys
     *
     * @param mixed ...$keys
     *
     * @return Collection<TKey, T>
     */
    public function intersectKeys(...$keys): Collection;
}
