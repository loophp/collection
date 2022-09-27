<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Keysable
{
    /**
     * Get the keys of the items.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#keys
     *
     * @return Collection<int, TKey>
     */
    public function keys(): Collection;
}
