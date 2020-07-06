<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template TKey
 * @psalm-template TKey of array-key
 * @template U
 */
interface Intersperseable
{
    /**
     * Insert a given value between each element of a collection.
     * Indices are not preserved.
     *
     * @param mixed $element
     * @psalm-param U $element
     *
     * @return Collection<int|TKey, T|U>
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): Collection;
}
