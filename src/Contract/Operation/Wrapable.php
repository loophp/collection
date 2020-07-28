<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Wrapable
{
    /**
     * @return Collection<int, array<TKey, T>>
     */
    public function wrap(): Collection;
}
