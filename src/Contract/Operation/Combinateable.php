<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Combinateable
{
    /**
     * Get all the combinations of a given length of a collection of items.
     *
     * @param int $length
     *   The length.
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function combinate(?int $length = null): Collection;
}
