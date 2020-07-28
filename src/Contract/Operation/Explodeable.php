<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Explodeable
{
    /**
     * Explode a collection into subsets on a given value.
     *
     * @param mixed ...$explodes
     *
     * @return Collection<int, array<int, T>>
     */
    public function explode(...$explodes): Collection;
}
