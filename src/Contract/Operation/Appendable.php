<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Appendable
{
    /**
     * Add one or more items to a collection.
     *
     * @param T ...$items
     *
     * @return Collection<TKey, T>
     */
    public function append(...$items): Collection;
}
