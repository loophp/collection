<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Filterable
{
    /**
     * Filter collection items based on one or more callbacks.
     *
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function filter(callable ...$callbacks): Collection;
}
