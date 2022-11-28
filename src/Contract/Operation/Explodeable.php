<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Explodeable
{
    /**
     * Explode a collection into subsets based on a given value.
     * This operation uses the `split` operation with the flag `Splitable::REMOVE` and thus,
     * values used to explode the collection are removed from the chunks.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#explode
     *
     * @return Collection<int, list<T>>
     */
    public function explode(mixed ...$explodes): Collection;
}
