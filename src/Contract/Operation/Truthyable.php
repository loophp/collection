<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Truthyable
{
    /**
     * Check if the collection contains only truthy values. Opposite of `falsy`.
     * A value is determined to be truthy by applying a `bool` cast.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#truthy
     */
    public function truthy(): bool;
}
