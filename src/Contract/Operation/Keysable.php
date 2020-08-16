<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Keysable
{
    /**
     * Get the keys of the items.
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function keys(): Collection;
}
