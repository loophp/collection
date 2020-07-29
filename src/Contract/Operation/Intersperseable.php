<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Intersperseable
{
    /**
     * Insert a given value between each element of a collection.
     * Indices are not preserved.
     *
     * @param mixed $element
     *
     * @return \loophp\collection\Base<TKey, T>|\loophp\collection\Contract\Collection<TKey, T>
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): Base;
}
