<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template TKey
 * @psalm-template TKey of array-key
 */
interface Nthable
{
    /**
     * Get every n-th element of a collection.
     *
     * @return Collection<TKey, T>
     */
    public function nth(int $step, int $offset = 0): Collection;
}
