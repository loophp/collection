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
     * @psalm-param T $init
     * @psalm-param callable(T): T $callback
     *
     * @psalm-return static<T, T>
     *
     * @param mixed $init
     */
    public static function unfold($init, callable $callback): Collection;
}
