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
    public const BY_KEYS = 1;

    public const BY_VALUES = 0;

    /**
     * Sort a collection using a callback.
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function sort(int $type = Sortable::BY_VALUES, ?callable $callback = null): Collection;
}
