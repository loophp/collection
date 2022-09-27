<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Hasable
{
    /**
     * Check if the collection has values with the help of one or more callables.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#has
     *
     * @param callable(T=, TKey=, iterable<TKey, T>=): T ...$callbacks
     */
    public function has(callable ...$callbacks): bool;
}
