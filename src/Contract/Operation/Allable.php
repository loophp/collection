<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Allable
{
    /**
     * Convert the collection into an array.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#all
     *
     * @param bool $normalize
     *
     * @psalm-return ($normalize is true ? list<T> : array<TKey, T>)
     */
    public function all(bool $normalize = true): array;
}
