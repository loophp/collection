<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template TKey
 * @psalm-template TKey of array-key
 */
interface Prependable
{
    /**
     * Push an item onto the beginning of the collection.
     *
     * @param array<TKey, T> ...$items
     *
     * @return Collection<TKey, T>
     */
    public function prepend(...$items): Collection;
}
