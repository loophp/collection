<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template TKey
 * @psalm-template T of array-key
 */
interface Flipable
{
    /**
     * Flip keys and items in a collection.
     *
     * @return Collection<T, TKey>
     */
    public function flip(): Collection;
}
