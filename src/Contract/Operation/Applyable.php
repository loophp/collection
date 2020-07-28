<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Applyable
{
    /**
     * Execute a callback for each element of the collection.
     *
     * @param callable ...$callables
     * @psalm-param callable(T, TKey): bool ...$callables
     *
     * @return Collection<TKey, T>
     */
    public function apply(callable ...$callables): Collection;
}
