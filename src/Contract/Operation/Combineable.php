<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Combineable
{
    /**
     * Combine a collection of items with some other keys.
     *
     * @param mixed ...$keys
     * @psalm-param TKey ...$keys
     *
     * @return Collection<TKey, T>
     */
    public function combine(...$keys): Collection;
}
