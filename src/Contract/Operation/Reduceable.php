<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Reduceable
{
    /**
     * Reduce a collection of items through a given callback.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#reduce
     *
     * @template V
     * @template W
     *
     * @param callable((V|W)=, T=, TKey=, iterable<TKey, T>=): W $callback
     * @param V $initial
     *
     * @return W
     */
    public function reduce(callable $callback, $initial = null);
}
