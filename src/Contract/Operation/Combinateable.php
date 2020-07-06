<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 */
interface Combinateable
{
    /**
     * Get all the combinations of a given length of a collection of items.
     *
     * @return Collection<int, list<T>>
     */
    public function combinate(?int $length = null): Collection;
}
