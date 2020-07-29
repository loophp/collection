<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Mapable
{
    /**
     * Apply one or more callbacks to a collection and use the return value.
     *
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Base<TKey, T>|\loophp\collection\Contract\Collection<TKey, T>
     */
    public function map(callable ...$callbacks): Base;
}
