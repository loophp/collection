<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 */
interface Mapable
{
    /**
     * Apply one or more callbacks to a collection and use the return value.
     *
     * @param callable(T|U, TKey): (U) ...$callbacks
     *
     * @return Collection<TKey, T|U>
     */
    public function map(callable ...$callbacks): Collection;
}
