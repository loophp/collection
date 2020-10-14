<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Generator;
use Iterator;
use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Pipeable
{
    /**
     * @psalm-param callable(Iterator<TKey, T>): Generator<TKey, T> ...$callables
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function pipe(callable ...$callables): Collection;
}
