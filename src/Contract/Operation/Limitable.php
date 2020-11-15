<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Limitable
{
    /**
     * Limit the amount of items in the collection to...
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function limit(int $count = -1, int $offset = 0): Collection;
}
