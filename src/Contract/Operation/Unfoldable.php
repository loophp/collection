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
     * @param callable(T ...): list<T> $callback
     * @param array<int, T> $parameters
     *
     * @return Collection<int, list<T>>
     */
    public static function unfold(callable $callback, array $parameters = []): Collection;
}
