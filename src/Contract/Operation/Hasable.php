<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Hasable
{
    /**
     * @psalm-param callable(TKey, T):(bool) $callback
     */
    public function has(callable $callback): bool;
}
