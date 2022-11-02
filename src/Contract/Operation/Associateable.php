<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;
use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Associateable
{
    /**
     * Transform keys and values of the collection independently and combine them.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#associate
     *
     * @template UKey
     * @template U
     *
     * @param callable(TKey=, T=, Iterator<TKey, T>=): UKey $callbackForKeys
     * @param callable(T=, TKey=, Iterator<TKey, T>=): U $callbackForValues
     *
     * @return Collection<UKey, U>
     */
    public function associate(?callable $callbackForKeys = null, ?callable $callbackForValues = null): Collection;
}
