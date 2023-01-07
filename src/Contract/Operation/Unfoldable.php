<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Unfoldable
{
    /**
     * Create a collection by yielding from a callback with an initial value.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#unfold
     *
     * @template T
     *
     * @param callable(T...): iterable<array-key, T> $callback
     * @param iterable<array-key, T> $parameters
     *
     * @return Collection<int, iterable<array-key, T>>
     */
    public static function unfold(callable $callback, iterable $parameters = []): Collection;
}
