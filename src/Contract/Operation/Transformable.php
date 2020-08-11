<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Transformable
{
    /**
     * @param \loophp\collection\Contract\Operation<TKey, T> ...$operations
     * @psalm-param \loophp\collection\Contract\Operation<TKey, T> ...$operations
     *
     * @return \loophp\collection\Iterator\ClosureIterator|mixed
     */
    public function transform(Operation ...$operations);
}
