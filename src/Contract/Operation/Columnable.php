<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Columnable
{
    /**
     * Return the values from a single column in the input iterables.
     *
     * @param int|string $index
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function column($index): Collection;
}
