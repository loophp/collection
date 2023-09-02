<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface CountInAble
{
    /**
     * This operation requires a reference to a parameter that will contain the
     * amount of items in the collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#countIn
     *
     * @param non-negative-int $counter
     *
     * @return Collection<TKey, T>
     */
    public function countIn(int &$counter): Collection;
}
