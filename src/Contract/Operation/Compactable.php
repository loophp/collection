<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Compactable
{
    /**
     * Combine a collection of items with some other keys.
     *
     * @param T|null ...$values
     *
     * @return Collection<TKey, T>
     */
    public function compact(...$values): Collection;
}
