<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Hasable
{
    /**
     * @psalm-param callable(TKey, T):(bool) $callback
     */
    public function has(callable $callback): bool;
}
