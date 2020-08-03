<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Intersectable
{
    /**
     * @param mixed ...$values
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function intersect(...$values): Collection;
}
