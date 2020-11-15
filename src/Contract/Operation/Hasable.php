<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Hasable
{
    /**
     * @psalm-param callable(TKey, T): bool $callback
     *
     * @psalm-return \loophp\collection\Collection<int, bool>
     */
    public function has(callable $callback): Collection;
}
