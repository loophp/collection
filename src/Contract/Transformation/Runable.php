<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Runable
{
    /**
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function run(callable ...$operations);
}
