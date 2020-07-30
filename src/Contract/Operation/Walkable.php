<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Walkable
{
    /**
     * Apply one or more supplied callbacks to every item of a collection.
     *
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function walk(callable ...$callbacks): Collection;
}
