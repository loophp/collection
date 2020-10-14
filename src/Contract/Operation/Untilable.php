<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Untilable
{
    /**
     * @param callable ...$callbacks
     * @psalm-param callable(T, TKey):bool ...$callbacks
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function until(callable ...$callbacks): Collection;
}
