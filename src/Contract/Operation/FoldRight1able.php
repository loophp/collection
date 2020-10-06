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
interface FoldRight1able
{
    /**
     * @psalm-param callable(T, T, TKey, Iterator<TKey, T>): T $callback
     *
     * @return mixed
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T|null>
     */
    public function foldRight1(callable $callback): Collection;
}
