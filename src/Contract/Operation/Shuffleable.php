<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template TKey
 * @psalm-template TKey of array-key
 */
interface Shuffleable
{
    /**
     * Shuffle a collection.
     *
     * @return Collection<TKey, T>
     */
    public function shuffle(): Collection;
}
