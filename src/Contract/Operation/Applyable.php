<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Applyable
{
    /**
     * Execute a callback for each element of the collection.
     *
     * @param callable ...$callables
     * @psalm-param callable(TKey, T):(bool) ...$callables
     *
     * @return \loophp\collection\Base<TKey, T>|\loophp\collection\Contract\Collection<TKey, T>
     */
    public function apply(callable ...$callables): Base;
}
