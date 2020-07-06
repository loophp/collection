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
interface Groupable
{
    /**
     * @param null|callable(TKey, T): (U) $callback
     *
     * @return Collection<TKey, list<T>|T>
     */
    public function group(?callable $callback = null): Collection;
}
