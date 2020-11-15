<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Forgetable
{
    /**
     * Remove items having specific keys.
     *
     * @param mixed ...$keys
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function forget(...$keys): Collection;
}
