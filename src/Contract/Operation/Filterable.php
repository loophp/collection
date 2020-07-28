<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Filterable
{
    /**
     * Filter collection items Collection on one or more callbacks.
     *
     * @param callable ...$callbacks
     * @psalm-param callable(T, TKey, \Iterator<TKey, T>): bool ...$callbacks
     *
     * @return Collection<TKey, T>
     */
    public function filter(callable ...$callbacks): Collection;
}
