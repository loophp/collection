<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Runable
{
    /**
     * @param \loophp\collection\Contract\Operation ...$operations
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function run(Operation ...$operations);
}
