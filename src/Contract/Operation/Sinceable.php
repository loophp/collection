<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template TKey
 * @psalm-template TKey of array-key
 */
interface Sinceable
{
    /**
     * @param callable(T, TKey): (bool) ...$callbacks
     *
     * @return Collection<TKey, T>
     */
    public function since(callable ...$callbacks): Collection;
}
