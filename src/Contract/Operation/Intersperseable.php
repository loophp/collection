<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Intersperseable
{
    /**
     * Insert a given value between each element of a collection.
     * Indices are not preserved.
     *
     * @param mixed $element
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): Collection;
}
