<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Reductionable
{
    /**
     * Reduce a collection of items through a given callback.
     *
     * @param mixed $initial
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function reduction(callable $callback, $initial = null): Collection;
}
