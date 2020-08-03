<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Sortable
{
    /**
     * Sort a collection using a callback.
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function sort(?callable $callable = null): Collection;
}
