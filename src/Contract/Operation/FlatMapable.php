<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface FlatMapable
{
    /**
     * Transform the collection using a callback and keep the return value, then flatten it one level.
     * The supplied callback needs to return an `iterable`: either an `array`or a class that implements Traversable.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#flatmap
     *
     * @template UKey
     * @template U
     *
     * @param callable(T=, TKey=, iterable<TKey, T>=): iterable<UKey, U> $callback
     *
     * @return Collection<UKey, U>
     */
    public function flatMap(callable $callback): Collection;
}
