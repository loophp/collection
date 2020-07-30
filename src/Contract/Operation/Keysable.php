<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Keysable
{
    /**
     * Get the keys of the items.
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function keys(): Collection;
}
