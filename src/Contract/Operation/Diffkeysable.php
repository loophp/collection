<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Diffkeysable
{
    /**
     * Compares the collection against another collection, iterable, or set of multiple keys.
     * This method will return the key / value pairs in the original collection that are not
     * present in the given argument set.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#diffkeys
     *
     * @param TKey ...$keys
     *
     * @return Collection<TKey, T>
     */
    public function diffKeys(mixed ...$keys): Collection;
}
