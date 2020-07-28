<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 */
interface Diffkeysable
{
    /**
     * @param U ...$values
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function diffKeys(...$values): Collection;
}
