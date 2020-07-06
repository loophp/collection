<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey of array-key
 * @template T
 * @template TKey
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
