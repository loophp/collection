<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Partitionable
{
    /**
     * @param callable ...$callbacks
     * @psalm-param callable(T, TKey):bool ...$callbacks
     *
     * @psalm-return \loophp\collection\Collection<int, array{int, array<0: TKey, 1: T>}>
     */
    public function partition(callable ...$callbacks): Collection;
}
