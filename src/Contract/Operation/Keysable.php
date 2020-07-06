<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template TKey
 * @psalm-template TKey of array-key
 */
interface Keysable
{
    /**
     * Get the keys of the items.
     *
     * @return Collection<int, TKey>
     */
    public function keys(): Collection;
}
