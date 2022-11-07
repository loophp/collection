<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Sinceable
{
    /**
     * Skip items until the callback is met.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#since
     *
     * @param callable(T, TKey, iterable<TKey, T>):bool ...$callbacks
     *
     * @return Collection<TKey, T>
     */
    public function since(callable ...$callbacks): Collection;
}
