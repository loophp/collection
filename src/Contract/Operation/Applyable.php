<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Applyable
{
    /**
     * Execute a callback for each element of the collection.
     *
     * @param callable ...$callables
     * @psalm-param callable(TKey, T):bool ...$callables
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function apply(callable ...$callables): Collection;
}
