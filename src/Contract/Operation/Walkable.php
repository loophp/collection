<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 */
interface Walkable
{
    /**
     * Apply one or more supplied callbacks to every item of a collection.
     *
     * @param callable(T, TKey): (U) ...$callbacks
     *
     * @return Collection<TKey, T|U>
     */
    public function walk(callable ...$callbacks): Collection;
}
