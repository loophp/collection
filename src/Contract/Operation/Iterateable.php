<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Iterateable
{
    /**
     * @template T
     * @psalm-template TKey of array-key
     * @template V
     * @template W
     *
     * @param callable(V|W):(W) $callback
     * @param V ...$parameters
     *
     * @return Collection<int, W>
     */
    public static function iterate(callable $callback, ...$parameters): Collection;
}
