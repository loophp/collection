<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Unfoldable
{
    /**
     * @psalm-template TKey
     * @psalm-template TKey of array-key
     * @psalm-template T
     *
     * @psalm-param callable(T...): array<TKey, T> $callback
     * @psalm-param T ...$parameters
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public static function unfold(callable $callback, ...$parameters): Collection;
}
