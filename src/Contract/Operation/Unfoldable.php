<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Unfoldable
{
    /**
     * Create a collection by yielding from a callback with an initial value.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#unfold
     *
     * @template U of T
     *
     * @param callable(U ...): list<U> $callback
     * @param array<int, U> $parameters
     *
     * @return Collection<int, list<U>>
     */
    public static function unfold(callable $callback, array $parameters = []): Collection;
}
