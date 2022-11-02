<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;

/**
 * @template TKey
 * @template T
 */
interface FoldRight1able
{
    /**
     * @template V
     *
     * @param callable(T|V, T, TKey, Iterator<TKey, T>): V $callback
     *
     * @return T|V|null
     */
    public function foldRight1(callable $callback);
}
