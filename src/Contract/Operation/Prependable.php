<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Prependable
{
    /**
     * Push an item onto the beginning of the collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#prepend
     *
     * @param mixed ...$items
     *
     * @return Collection<int|TKey, T>
     */
    public function prepend(...$items): Collection;
}
