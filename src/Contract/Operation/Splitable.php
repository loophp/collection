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
interface Splitable
{
    /**
     * Split a collection using a callback.
     *
     * @param callable(T, TKey):(U|bool) ...$callbacks
     *
     * @return Collection<int, array<int, T>>
     */
    public function split(callable ...$callbacks): Collection;
}
