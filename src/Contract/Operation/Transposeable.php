<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Transposeable
{
    /**
     * Matrix transposition.
     *
     * @return Collection<TKey, array<int, T>>
     */
    public function transpose(): Collection;
}
