<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Plusable
{
    /**
     * TODO - Plus items.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#plus
     *
     * @template UKey
     * @template U
     *
     * @param iterable<UKey, U> $items
     *
     * @return Collection<int|TKey|UKey, T|U>
     */
    public function plus(iterable $items): Collection;
}
