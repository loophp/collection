<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Everyable
{
    /**
     * Check whether all elements in the collection pass the test implemented by the provided callback(s).
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#every
     *
     * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
     */
    public function every(callable ...$callbacks): bool;
}
