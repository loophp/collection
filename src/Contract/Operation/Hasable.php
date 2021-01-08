<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;
use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Hasable
{
    /**
     * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool $callback
     *
     * @psalm-return \loophp\collection\Collection<int, bool>
     */
    public function has(callable ...$callbacks): Collection;
}
