<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template TKey
 * @psalm-template TKey of array-key
 * @template U
 * @template V
 */
interface Reductionable
{
    /**
     * Reduce a collection of items through a given callback.
     *
     * @param callable(U|V, T, TKey): (V) $callback
     * @param U|null $initial
     *
     * @return Collection<int, T>
     */
    public function reduction(callable $callback, $initial = null): Collection;
}
