<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Forgetable
{
    /**
     * Remove items having specific keys.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#forget
     *
     * @return Collection<TKey, T>
     */
    public function forget(mixed ...$keys): Collection;
}
