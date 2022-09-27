<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Findable
{
    /**
     * Find a value in the collection that matches all predicates or return the
     * default value.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#find
     *
     * @template V
     *
     * @param V $default
     * @param (callable(T=, TKey=, iterable<TKey, T>=): bool) ...$callbacks
     *
     * @return T|V
     */
    public function find($default = null, callable ...$callbacks);
}
